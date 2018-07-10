<?php

namespace backend\modules\sales\controllers;

use Yii;
use common\models\ProductSaleMaster;
use common\models\ProductSaleMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ProductSaleDetails;
use common\models\ProductStockRegister;
use common\models\ProductStockView;

/**
 * ProductSaleMasterController implements the CRUD actions for ProductSaleMaster model.
 */
class ProductSaleMasterController extends Controller {

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
     * Lists all ProductSaleMaster models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProductSaleMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductSaleMaster model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $model_details = ProductSaleDetails::find()->where(['master_id' => $model->id])->all();
        return $this->render('view', [
                    'model' => $model,
                    'model_details' => $model_details,
        ]);
    }

    /**
     * Creates a new ProductSaleMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ProductSaleMaster();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionAdd() {
        $model = new \common\models\ProductSaleDetails();
        $model_master = new ProductSaleMaster();
        if ($model_master->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post();
            $model_master->date = date("Y-m-d", strtotime($model_master->date));
            Yii::$app->SetValues->Attributes($model_master);
            $arr = $this->SaveSaleDetails($model_master, $data);
            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($model_master->save() && $this->AddSaleDetails($arr, $model_master)) {
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
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('add', [
                    'model' => $model,
                    'model_master' => $model_master,
        ]);
    }

    public function SaveSaleDetails($model_master, $data) {
        $arr = [];
        $i = 0;
        foreach ($data['ProductSaleDetailsMaterial'] as $val) {
            $arr[$i]['ProductSaleDetailsMaterial'] = $val;
            $i++;
        }
        $i = 0;
        foreach ($data['ProductSaleDetailsQty'] as $val) {
            $arr[$i]['ProductSaleDetailsQty'] = $val;
            $i++;
        }
        $i = 0;
        foreach ($data['ProductSaleDetailsUnit'] as $val) {
            $arr[$i]['ProductSaleDetailsUnit'] = $val;
            $i++;
        }
        $i = 0;
        foreach ($data['ProductSaleDetailsComment'] as $val) {
            $arr[$i]['ProductSaleDetailsComment'] = $val;
            $i++;
        }
        return $arr;
    }

    public function AddSaleDetails($arr, $model_master) {
        $flag = 0;
        $i=0;
        foreach ($arr as $val) {
            $i++;
            $aditional = new ProductSaleDetails();
            $item_datas = \common\models\FinishedProduct::find()->where(['id' => $val['ProductSaleDetailsMaterial']])->one();
            if (!empty($item_datas)) {
                $aditional->master_id = $model_master->id;
                $aditional->material = $item_datas->id;
                $aditional->quantity = $val['ProductSaleDetailsQty'];
                $aditional->unit = $item_datas->unit;
                $aditional->comment = $val['ProductSaleDetailsComment'];
                $aditional->CB = Yii::$app->user->identity->id;
                $aditional->UB = Yii::$app->user->identity->id;
                $aditional->DOC = date('Y-m-d');
                if ($aditional->save()) {
                    if ($this->AddStockRegister($aditional)) {
                        $flag = 1;
                    }else{
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

    public function AddStockRegister($aditional) {
        $flag = 0;
        $stock = new ProductStockRegister();
        $stock->document_line_id = $aditional->id;
        $stock->product_id = $aditional->material;
        $stock->type = 1;
        $stock->stock_out = $aditional->quantity;
        $stock->unit = $aditional->unit;
        $stock->status = 1;
        $stock->CB = Yii::$app->user->identity->id;
        $stock->UB = Yii::$app->user->identity->id;
        $stock->DOC = date('Y-m-d');
        if ($stock->save()) {
            if ($this->AddStockView($aditional, $stock)) {
                $flag = 1;
            }else{
                 $flag = 0;
            }
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function AddStockView($aditional, $stock) {
        $stock_view_exist = ProductStockView::find()->where(['product_id' => $stock->product_id])->one();
        if (empty($stock_view_exist)) {
            $stock_view = new ProductStockView();
            $stock_view->product_id = $stock->product_id;
            $stock_view->available_qty = $stock->stock_out;
            $stock_view->unit = $stock->unit;
            $stock_view->status = 1;
            $stock_view->CB = Yii::$app->user->identity->id;
            $stock_view->UB = Yii::$app->user->identity->id;
            $stock_view->DOC = date('Y-m-d');
        } else {
            $stock_view = ProductStockView::find()->where(['product_id' => $stock->product_id])->one();
            $stock_view->available_qty -= $stock->stock_out;
        }
        if ($stock_view->save()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Updates an existing ProductSaleMaster model.
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
     * Deletes an existing ProductSaleMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductSaleMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductSaleMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ProductSaleMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetItems() {
        if (Yii::$app->request->isAjax) {
            $item_id = $_POST['item_id'];
            $avail_qty = 0;
            $unit = '';
            $item_datas = \common\models\SupplierwiseRowMaterial::find()->where(['id' => $item_id])->one();
            if (!empty($item_datas)) {
                $unit = $item_datas->item_unit != '' ? \common\models\Unit::findOne($item_datas->item_unit)->unit_name : '';
                $stock = \common\models\ProductStockView::find()->where(['product_id' => $item_id])->one();
                if (!empty($stock)) {
                    $avail_qty = $stock->available_qty;
                }
            }
            $new_row = array('avail_qty' => $avail_qty, 'unit' => $unit);
            $data['result'] = $new_row;
            return json_encode($data);
        }
    }

    public function actionAddAnotherRow() {
        if (Yii::$app->request->isAjax) {
            $next_row_id = $_POST['next_row_id'];
            $next = $next_row_id + 1;
            $items = \common\models\FinishedProduct::findAll(['status' => 1]);
            $next_row = $this->renderPartial('next_row', [
                'next' => $next,
                'items' => $items,
            ]);
            $new_row = array('next_row_html' => $next_row);
            $data['result'] = $new_row;
            echo json_encode($data);
        }
    }

}
