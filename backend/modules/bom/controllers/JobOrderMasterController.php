<?php

namespace backend\modules\bom\controllers;

use Yii;
use common\models\JobOrderMaster;
use common\models\JobOrderMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\JobOrderDetails;
use common\models\StockView;

/**
 * JobOrderMasterController implements the CRUD actions for JobOrderMaster model.
 */
class JobOrderMasterController extends Controller {

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
     * Lists all JobOrderMaster models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new JobOrderMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Get BOM number.
     * @return mixed
     */
    public function getBomNo() {
        $bom_last = JobOrderMaster::find()->orderBy(['id' => SORT_DESC])->one();
        if (!empty($bom_last)) {
            $num = $bom_last->id + 1;
        } else {
            $num = 1;
        }
        return 'BOM' . $num;
    }

    /**
     * Displays a single JobOrderMaster model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $bom_detail = JobOrderDetails::find()->where(['master_id' => $model->id])->one();
        return $this->render('view', [
                    'model' => $model,
                    'bom_detail' => $bom_detail,
        ]);
    }

    /**
     * Creates a new JobOrderMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new JobOrderMaster();
        $model_details = new JobOrderDetails();

        if ($model->load(Yii::$app->request->post()) && $model_details->load(Yii::$app->request->post())) {
            $model->bom_date = date("Y-m-d", strtotime($model->bom_date));
            if ($model_details->damaged == '') {
                $model_details->damaged = 0;
            }
            Yii::$app->SetValues->Attributes($model);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->save() && $this->SaveBomDetails($model, $model_details)) {
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
                        'model_details' => $model_details,
            ]);
        }
    }

    /*
     * Save BOM details
     */

    public function SaveBomDetails($model, $model_details) {
        $flag = 0;
        $model_details->master_id = $model->id;
        if ($model_details->save()) {
            if ($this->AddStockRegister($model, $model_details)) {
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
     * This function add each BOM material details into stock register.
     */
    public function AddStockRegister($model, $model_details) {
        $flag = 0;
        $flag1 = 0;
        $item_datas = \common\models\SupplierwiseRowMaterial::find()->where(['id' => $model_details->bottle])->one();
        $stock = new \common\models\StockRegister();
        $stock->type = 6;
        $stock->document_line_id = $model_details->id;
        $stock->invoice_no = $model->bom_no;
        $stock->invoice_date = $model->bom_date;
        $stock->item_id = $model_details->bottle;
        $stock->item_code = $item_datas->item_code;
        $stock->item_name = $item_datas->item_name;
        $stock->weight_out = $model_details->qty + $model_details->damaged;
        $stock->status = 1;
        $stock->CB = Yii::$app->user->identity->id;
        $stock->UB = Yii::$app->user->identity->id;
        $stock->DOC = date('Y-m-d');
        if ($stock->save()) {
            if ($this->DeductStockView($stock, $model_details)) {
                $flag = 1;
            } else {
                $flag = 0;
            }
        }
        $item_datas1 = \common\models\SupplierwiseRowMaterial::find()->where(['id' => $model_details->named_bottle])->one();
        $stock1 = new \common\models\StockRegister();
        $stock1->type = 6;
        $stock1->document_line_id = $model_details->id;
        $stock1->invoice_no = $model->bom_no;
        $stock1->invoice_date = $model->bom_date;
        $stock1->item_id = $model_details->named_bottle;
        $stock1->item_code = $item_datas1->item_code;
        $stock1->item_name = $item_datas1->item_name;
        $stock1->weight_in = $model_details->quantity;
        $stock1->status = 1;
        $stock1->CB = Yii::$app->user->identity->id;
        $stock1->UB = Yii::$app->user->identity->id;
        $stock1->DOC = date('Y-m-d');
        if ($stock1->save()) {
            if ($this->AddStockView($stock1, $model_details)) {
                $flag1 = 1;
            } else {
                $flag1 = 0;
            }
        }
        if ($flag == 1 && $flag1 == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function DeductStockView($stock, $model_details) {
        $stock_view_exist = \common\models\StockView::find()->where(['material_id' => $stock->item_id])->one();
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
        }
        if ($stock_view->save()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function AddStockView($stock, $model_details) {
        $stock_view_exist = \common\models\StockView::find()->where(['material_id' => $stock->item_id])->one();
        if (empty($stock_view_exist)) {
            $stock_view = new StockView();
            $stock_view->material_id = $stock->item_id;
            $stock_view->available_qty = $stock->weight_in;
            $stock_view->status = 1;
            $stock_view->CB = Yii::$app->user->identity->id;
            $stock_view->UB = Yii::$app->user->identity->id;
            $stock_view->DOC = date('Y-m-d');
        } else {
            $stock_view = StockView::find()->where(['material_id' => $stock->item_id])->one();
            $stock_view->available_qty += $stock->weight_in;
        }
        if ($stock_view->save()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Updates an existing JobOrderMaster model.
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
     * Deletes an existing JobOrderMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the JobOrderMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return JobOrderMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = JobOrderMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionBottleDetails() {
        if (Yii::$app->request->isAjax) {
            $material_id = $_POST['material_id'];
            $stock = \common\models\StockView::find()->where(['material_id' => $material_id])->one();
            $stock_val = 0;
            if (!empty($stock)) {
                $stock_val = $stock->available_qty;
            }
            return $stock_val;
        }
    }

}
