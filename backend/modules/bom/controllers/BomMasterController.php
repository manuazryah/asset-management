<?php

namespace backend\modules\bom\controllers;

use Yii;
use common\models\BomMaster;
use common\models\BomMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\StockView;

/**
 * BomMasterController implements the CRUD actions for BomMaster model.
 */
class BomMasterController extends Controller {

    public function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app->user->isGuest) {
            $this->redirect(['/site/index']);
            return false;
        }
        return true;
    }

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
     * Lists all BomMaster models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BomMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BomMaster model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $bom_details = \common\models\Bom::find()->where(['master_id' => $model->id])->all();
        return $this->render('view', [
                    'model' => $model,
                    'bom_details' => $bom_details,
        ]);
    }

    /**
     * Creates a new BomMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new BomMaster();

        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post();
            $model->date = date("Y-m-d", strtotime($model->date));
            Yii::$app->SetValues->Attributes($model);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->save() && $this->SaveBomDetails($model, $data)) {
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
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /*
     * Save BOM details
     */

    public function SaveBomDetails($model, $data) {
        $flag = 0;
        if (!empty($data['creatematerial'])) {
            foreach ($data['create'] as $key => $create) {
                if (!empty($data['creatematerial'][$key])) {
                    if ($this->BomCreate($model, $create, $key, $data['creatematerial'][$key])) {
                        $flag = 1;
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
     * To set sales details into an array.
     */
    public function BomCreate($model, $create, $key, $creatematerial) {
        $flag = 0;
        if ($create['product'] != '' && $create['product_qty'] != '' && $create['product_qty'] > 0) {
            $bom_details = new \common\models\Bom();
            $bom_details->master_id = $model->id;
            $bom_details->product = $create['product'];
            $bom_details->qty = $create['product_qty'];
            $bom_details->comment = $create['product_comment'];
            Yii::$app->SetValues->Attributes($bom_details);
            if ($bom_details->save()) {
                if ($this->BomMaterial($model, $bom_details, $key, $creatematerial)) {
                    $flag = 1;
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
     * To set sales details into an array.
     */
    public function BomMaterial($model, $bom_details, $key, $creatematerial) {
        $flag = 0;
        if (isset($creatematerial) && $creatematerial != '') {
            $arr = [];
            $i = 0;
            if (!empty($creatematerial['material_id'])) {
                foreach ($creatematerial['material_id'] as $val) {
                    $arr[$i]['material_id'] = $val;
                    $i++;
                }
            }
            $i = 0;
            if (!empty($creatematerial['material_qty'])) {
                foreach ($creatematerial['material_qty'] as $val) {
                    $arr[$i]['material_qty'] = $val;
                    $i++;
                }
            }
            $i = 0;
            if (!empty($creatematerial['material_comment'])) {
                foreach ($creatematerial['material_comment'] as $val) {
                    $arr[$i]['material_comment'] = $val;
                    $i++;
                }
            }
            if ($this->AddMaterialDetails($model, $arr, $bom_details)) {
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
     * This function save material details.
     */
    public function AddMaterialDetails($model, $arr, $bom_details) {
        $flag = 0;
        foreach ($arr as $val) {
            $aditional = new \common\models\BomMaterialDetails();
            $aditional->bom_id = $bom_details->id;
            $aditional->material = $val['material_id'];
            $aditional->quantity = $val['material_qty'];
            $aditional->comment = $val['material_comment'];
            Yii::$app->SetValues->Attributes($aditional);
            if ($aditional->save()) {
                if ($this->CreateStockView($aditional)) {
                    $flag = 1;
                }
            }
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function CreateStockView($material) {
        $stock_view_exist = StockView::find()->where(['material_id' => $material->material])->one();
        if (empty($stock_view_exist)) {
            $stock_view = new StockView();
            $stock_view->material_id = $material->material;
            $stock_view->reserved_qty = $material->quantity;
            $stock_view->status = 1;
            $stock_view->CB = Yii::$app->user->identity->id;
            $stock_view->UB = Yii::$app->user->identity->id;
            $stock_view->DOC = date('Y-m-d');
        } else {
            $stock_view = StockView::find()->where(['material_id' => $material->material])->one();
            $stock_view->reserved_qty += $material->quantity;
            $stock_view->available_qty -= $material->quantity;
        }
        if ($stock_view->save()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * This function add each BOM material details into stock register.
     */
    public function AddStockRegister($model, $aditional) {
        $flag = 0;
        $item_datas = \common\models\SupplierwiseRowMaterial::find()->where(['id' => $aditional->material])->one();
        $stock = new \common\models\StockRegister();
        $stock->type = 2;
        $stock->document_line_id = $aditional->id;
        $stock->invoice_no = $model->bom_no;
        $stock->invoice_date = $model->date;
        $stock->item_id = $aditional->material;
        $stock->item_code = $item_datas->item_code;
        $stock->item_name = $item_datas->item_name;
//        $stock->warehouse = $aditional->warehouse;
//        $stock->shelf = $aditional->shelf;
//        $stock->item_cost = $aditional->price;
        $stock->weight_out = $aditional->actual_qty;
        $stock->status = 1;
        $stock->CB = Yii::$app->user->identity->id;
        $stock->UB = Yii::$app->user->identity->id;
        $stock->DOC = date('Y-m-d');
        if ($stock->save()) {
            if ($this->AddStockView($stock, $aditional)) {
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

    public function AddStockView($stock, $aditional) {
        $stock_view_exist = StockView::find()->where(['material_id' => $stock->item_id])->one();
        if (empty($stock_view_exist)) {
            $stock_view = new StockView();
            $stock_view->material_id = $stock->item_id;
            $stock_view->available_qty = $stock->weight_out;
            $stock_view->status = 1;
            $stock_view->CB = Yii::$app->user->identity->id;
            $stock_view->UB = Yii::$app->user->identity->id;
            $stock_view->DOC = date('Y-m-d');
        } else {
            $stock_view = StockView::find()->where(['material_id' => $stock->item_id])->one();
            $stock_view->available_qty -= $stock->weight_out;
            $stock_view->reserved_qty -= $aditional->quantity;
        }
        if ($stock_view->save()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Updates an existing BomMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model_bom = \common\models\Bom::find()->where(['master_id' => $model->id])->all();
        $supplier_materials = \common\models\SupplierwiseRowMaterial::find()->all();
        if ($model->load(Yii::$app->request->post())) {
            $model->date = date("Y-m-d", strtotime($model->date));
            $data = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->save() && $this->UpdateBomDetails($model, $data) && $this->UpdateBomMaterial($model, $data)) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Invoice Updated successfully");
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', "There was a problem updating invoice. Please try again.");
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', "There was a problem updating invoice. Please try again.");
            }
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('form_update', [
                        'model' => $model,
                        'model_bom' => $model_bom,
                        'supplier_materials' => $supplier_materials,
            ]);
        }
    }

    /*
     * Save BOM details
     */

    public function UpdateBomDetails($model, $data) {
        $flag = 0;
        if (!empty($data['update'])) {
            foreach ($data['update'] as $key => $update) {
                $bom_detail = \common\models\Bom::find()->where(['id' => $key])->one();
                $bom_detail->comment = $update['product_comment'];
                if ($bom_detail->save()) {
                    $flag = 1;
                }
            }
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*
     * Save BOM details
     */

    public function UpdateBomMaterial($model, $data) {
        $flag = 0;
        $arr = [];
        if (!empty($data['updatematerial'])) {
            foreach ($data['updatematerial'] as $key => $update) {
                $bom_material_detail_prev = \common\models\BomMaterialDetails::find()->where(['id' => $key])->one();
                $bom_material_detail = \common\models\BomMaterialDetails::find()->where(['id' => $key])->one();
//                $bom_material_detail->material = $update['material_id'];
                $bom_material_detail->quantity = $update['material_qty'];
                $bom_material_detail->comment = $update['material_comment'];
                if ($bom_material_detail->save()) {
                    if ($this->UpdateStockView($bom_material_detail, $bom_material_detail_prev)) {
                        $flag = 1;
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

    public function UpdateStockView($material_new, $material_old) {
        $stock_view = StockView::find()->where(['material_id' => $material_new->material])->one();
        if ($material_new->quantity > $material_old->quantity) {
            $qty = $material_new->quantity - $material_old->quantity;
            $stock_view->reserved_qty += $qty;
            $stock_view->available_qty -= $qty;
        } elseif ($material_new->quantity < $material_old->quantity) {
            $qty = $material_old->quantity - $material_new->quantity;
            $stock_view->reserved_qty -= $qty;
            $stock_view->available_qty += $qty;
        }
        if ($stock_view->save()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Updates an existing BomMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionProduction($id) {
        $model = $this->findModel($id);
        $model_bom = \common\models\Bom::find()->where(['master_id' => $model->id])->all();
        $supplier_materials = \common\models\SupplierwiseRowMaterial::find()->all();
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 3;
            $model->date = date("Y-m-d", strtotime($model->date));
            $data = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->save() && $this->ProductionBomDetails($model, $data) && $this->ProductionBomMaterial($model, $data) && $this->ProductStock($data)) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Material Prodduction Completed successfully");
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', "There was a problem updating invoice. Please try again.");
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', "There was a problem updating invoice. Please try again.");
            }
            return $this->redirect('index');
        } else {
            return $this->render('form_production', [
                        'model' => $model,
                        'model_bom' => $model_bom,
                        'supplier_materials' => $supplier_materials,
            ]);
        }
    }

    /*
     * Save BOM details
     */

    public function ProductStock($data) {
        $flag = 0;
        if (!empty($data['update'])) {
            foreach ($data['update'] as $update) {
                if (!empty($update)) {
                    if ($update['product'] != '') {
                        $stock = new \common\models\ProductStockRegister();
                        $stock->product_id = $update['product'];
                        $stock->stock_in = $data['no_of_product'];
                        $stock->warehouse = $data['product_warehouse'];
                        $stock->unit = 1;
                        $stock->status = 1;
                        $stock->CB = Yii::$app->user->identity->id;
                        $stock->UB = Yii::$app->user->identity->id;
                        $stock->DOC = date('Y-m-d');
                        if ($stock->save()) {
                            if ($this->AddProductStockView($stock)) {
                                $flag = 1;
                            } else {
                                $flag = 0;
                            }
                        }
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
    
    public function AddProductStockView($stock) {
        $stock_view_exist = \common\models\ProductStockView::find()->where(['product_id' => $stock->product_id])->one();
        if (empty($stock_view_exist)) {
            $stock_view = new \common\models\ProductStockView();
            $stock_view->product_id = $stock->product_id;
            $stock_view->available_qty = $stock->stock_in;
            $stock_view->unit = $stock->unit;
            $stock_view->status = 1;
            $stock_view->CB = Yii::$app->user->identity->id;
            $stock_view->UB = Yii::$app->user->identity->id;
            $stock_view->DOC = date('Y-m-d');
        } else {
            $stock_view = \common\models\ProductStockView::find()->where(['product_id' => $stock->product_id])->one();
            $stock_view->available_qty += $stock->stock_in;
        }
        if ($stock_view->save()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*
     * Save BOM details
     */

    public function ProductionBomDetails($model, $data) {
        $flag = 0;
        if (!empty($data['update'])) {
            foreach ($data['update'] as $key => $update) {
                $bom_detail = \common\models\Bom::find()->where(['id' => $key])->one();
                $bom_detail->comment = $update['product_comment'];
                if ($bom_detail->save()) {
                    $flag = 1;
                }
            }
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*
     * Save BOM details
     */

    public function ProductionBomMaterial($model, $data) {
        $flag = 0;
        $arr = [];
        if (!empty($data['updatematerial'])) {
            foreach ($data['updatematerial'] as $key => $update) {
                $bom_material_detail = \common\models\BomMaterialDetails::find()->where(['id' => $key])->one();
//                $bom_material_detail->material = $update['material_id'];
                $bom_material_detail->quantity = $update['material_qty'];
                $bom_material_detail->comment = $update['material_comment'];
                $bom_material_detail->actual_qty = $update['actual_qty'];
                if ($bom_material_detail->save()) {
                    if ($this->AddStockRegister($model, $bom_material_detail)) {
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
     * Deletes an existing BomMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BomMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BomMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = BomMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * This function add new row for new Bom details entry
     * @return new row
     */
    public function actionGetBom() {
        if (Yii::$app->request->isAjax) {
            $j = $_POST['next'];
            $products = \common\models\FinishedProduct::find()->where(['status' => 1])->all();
            $new_row = $this->renderPartial('bom_row', [
                'products' => $products,
                'j' => $j,
            ]);
            return $new_row;
        }
    }

    /**
     * This function add new row for new Bom details entry
     * @return new row
     */
    public function actionBomComplete($id) {
        $model = $this->findModel($id);
        if (!empty($model)) {
            $model->status = 2;
            $model->update();
            return $this->redirect(['production', 'id' => $model->id]);
        } else {
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
     * This function find selected item details.
     * return item details as json array
     */
    public function actionGetItems() {
        if (Yii::$app->request->isAjax) {
            $item_id = $_POST['item_id'];
            $current_row_id = $_POST['current_row_id'];
            $finished_products = \common\models\FinishedProduct::find()->where(['id' => $item_id])->one();
            $material_details = \common\models\BomDetails::find()->where(['finished_product_id' => $finished_products->id])->all();
            $supplier_materials = \common\models\SupplierwiseRowMaterial::find()->all();
            $new_row = $this->renderPartial('material_row', [
                'finished_products' => $finished_products,
                'material_details' => $material_details,
                'current_row_id' => $current_row_id,
                'supplier_materials' => $supplier_materials,
            ]);
            $arr_variable1 = array('new_row' => $new_row, 'product_comment' => $finished_products->comment);
            $data['result'] = $arr_variable1;
            return json_encode($data);
        }
    }

    public function getBomNo() {
        $bom_last = BomMaster::find()->orderBy(['id' => SORT_DESC])->one();
        if (!empty($bom_last)) {
            $num = $bom_last->id + 1;
        } else {
            $num = 1;
        }
        return 'BOM' . $num;
    }

}
