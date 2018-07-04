<?php

namespace backend\modules\stock\controllers;

use Yii;
use common\models\MaterialAdjustmentMaster;
use common\models\MaterialAdjustmentMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MaterialAdjustmentMasterController implements the CRUD actions for MaterialAdjustmentMaster model.
 */
class MaterialAdjustmentMasterController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MaterialAdjustmentMaster models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MaterialAdjustmentMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MaterialAdjustmentMaster model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $model_details = \common\models\MaterialAdjustmentDetails::find()->where(['master_id' => $model->id])->all();
        return $this->render('view', [
                    'model' => $model,
                    'model_details' => $model_details,
        ]);
    }

    /**
     * Creates a new MaterialAdjustmentMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new MaterialAdjustmentMaster();

        if ($model->load(Yii::$app->request->post())) {
            $model->document_date = date("Y-m-d", strtotime($model->document_date));
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->save() && $this->InvoiceDetails($model)) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Invoice Created successfully");
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', "There was a problem creating new invoice. Please try again.");
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', "There was a problem creating new invoice. Please try again.");
            }
            $model = new MaterialAdjustmentMaster();
        } return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * To set sales details into an array.
     */
    public function InvoiceDetails($model_master) {
        $flag = 0;
        if (isset($_POST['create']) && $_POST['create'] != '') {
            $create = $_POST['create'];
            $arr = [];
            $i = 0;
            foreach ($create['item_id'] as $val) {
                $arr[$i]['item_id'] = $val;
                $i++;
            }
            $i = 0;
            foreach ($create['qty'] as $val) {
                $arr[$i]['qty'] = $val;
                $i++;
            }
            $i = 0;
            foreach ($create['price'] as $val) {
                $arr[$i]['price'] = $val;
                $i++;
            }
            $i = 0;
            foreach ($create['total'] as $val) {
                $arr[$i]['total'] = $val;
                $i++;
            }
            $i = 0;
            foreach ($create['warehouse'] as $val) {
                $arr[$i]['warehouse'] = $val;
                $i++;
            }
            if ($this->AddInvoiceDetails($arr, $model_master)) {
                $flag = 1;
            }
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * This function save sales invoice details.
     */
    public function AddInvoiceDetails($arr, $model_master) {
        $flag = 0;
        foreach ($arr as $val) {
            $aditional = new \common\models\MaterialAdjustmentDetails();
            $item_datas = \common\models\SupplierwiseRowMaterial::find()->where(['id' => $val['item_id']])->one();
            if (!empty($item_datas)) {
                $aditional->master_id = $model_master->id;
                $aditional->material_id = $item_datas->id;
                $aditional->qty = $val['qty'];
                $aditional->price = $val['price'];
                $aditional->total = $aditional->qty * $aditional->price;
                $aditional->warehouse = $val['warehouse'];
                $aditional->status = 1;
                $aditional->CB = Yii::$app->user->identity->id;
                $aditional->UB = Yii::$app->user->identity->id;
                $aditional->DOC = date('Y-m-d');
                if ($aditional->save()) {
                    if ($this->AddStockRegister($aditional, $model_master)) {
                        $flag = 1;
                    } else {
                        $flag = 0;
                    }
                }
            }
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * This function add each purchase material details into stock register.
     */
    public function AddStockRegister($aditional, $model_master) {
        $flag = 0;
        $item_datas = \common\models\SupplierwiseRowMaterial::find()->where(['id' => $aditional->material_id])->one();
        $stock = new \common\models\StockRegister();
        $stock->document_line_id = $aditional->id;
        $stock->invoice_no = $model_master->document_no;
        $stock->invoice_date = $model_master->document_date;
        $stock->item_id = $aditional->material_id;
        $stock->item_code = $item_datas->item_code;
        $stock->item_name = $item_datas->item_name;
        $stock->warehouse = $aditional->warehouse;
        $stock->item_cost = $aditional->price;
        if ($model_master->transaction == 0) {
            $stock->weight_in = $aditional->qty;
            $stock->type = 3;
        } elseif ($model_master->transaction == 1) {
            $stock->weight_in = $aditional->qty;
            $stock->type = 4;
        } elseif ($model_master->transaction == 2) {
            $stock->weight_out = $aditional->qty;
            $stock->type = 5;
        }
        $stock->status = 1;
        $stock->CB = Yii::$app->user->identity->id;
        $stock->UB = Yii::$app->user->identity->id;
        $stock->DOC = date('Y-m-d');
        if ($stock->save()) {
            if ($this->AddStockView($stock)) {
                $flag = 1;
            } else {
                $flag = 0;
            }
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function AddStockView($stock) {
        $stock_view_exist = \common\models\StockView::find()->where(['material_id' => $stock->item_id])->one();
        if (empty($stock_view_exist)) {
            $stock_view = new \common\models\StockView();
            $stock_view->material_id = $stock->item_id;
            if ($stock->type == 3 || $stock->type == 4) {
                $stock_view->available_qty = $stock->weight_in;
            } elseif ($stock->type == 5) {
                $stock_view->available_qty = $stock->weight_out;
            }
            $stock_view->status = 1;
            $stock_view->CB = Yii::$app->user->identity->id;
            $stock_view->UB = Yii::$app->user->identity->id;
            $stock_view->DOC = date('Y-m-d');
        } else {
            $stock_view = \common\models\StockView::find()->where(['material_id' => $stock->item_id])->one();
            if ($stock->type == 3 || $stock->type == 4) {
                $stock_view->available_qty += $stock->weight_in;
            } elseif ($stock->type == 5) {
                $stock_view->available_qty -= $stock->weight_out;
            }
        }
        if ($stock_view->save()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Updates an existing MaterialAdjustmentMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MaterialAdjustmentMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MaterialAdjustmentMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MaterialAdjustmentMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = MaterialAdjustmentMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * This function add another row in sales invoice form.
     * return next row html to form
     */
    public function actionAddAnotherRow() {
        if (Yii::$app->request->isAjax) {
            $next_row_id = $_POST['next_row_id'];
            $next = $next_row_id + 1;
            $item_datas = \common\models\SupplierwiseRowMaterial::findAll(['status' => 1]);
            $warehouse_datas = \common\models\Warehouse::findAll(['status' => 1]);
            $shelf_datas = \common\models\ShelfDetails::findAll(['status' => 1]);
            $next_row = $this->renderPartial('next_row', [
                'next' => $next,
                'item_datas' => $item_datas,
                'warehouse_datas' => $warehouse_datas,
                'shelf_datas' => $shelf_datas,
            ]);
            $new_row = array('next_row_html' => $next_row);
            $data['result'] = $new_row;
            return json_encode($data);
        }
    }

    /**
     * This function find selected item details.
     * return item details as json array
     */
    public function actionGetItems() {
        if (Yii::$app->request->isAjax) {
            $item_id = $_POST['item_id'];
            if ($item_id == '') {
                echo '0';
                exit;
            } else {
                $unit = '';
                $price = '';
                $avail = 0;
                $item_datas = \common\models\SupplierwiseRowMaterial::find()->where(['id' => $item_id])->one();
                if (!empty($item_datas)) {
                    $price = $item_datas->purchase_price;
                    $unit = $item_datas->item_unit != '' ? \common\models\Unit::findOne($item_datas->item_unit)->unit_name : '';
                    $stock = \common\models\StockView::find()->where(['material_id' => $item_datas->id])->one();
                    if (!empty($stock)) {
                        $avail = $stock->available_qty;
                    }
                }
                $arr_variable1 = array('unit' => $unit, 'price' => $price,'avail_qty'=>$avail);
                $data1['result'] = $arr_variable1;
                return json_encode($data1);
            }
        }
    }

}
