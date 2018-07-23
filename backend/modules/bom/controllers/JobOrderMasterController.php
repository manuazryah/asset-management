<?php

namespace backend\modules\bom\controllers;

use Yii;
use common\models\JobOrderMaster;
use common\models\JobOrderMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\JobOrderDetails;

/**
 * JobOrderMasterController implements the CRUD actions for JobOrderMaster model.
 */
class JobOrderMasterController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
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
    public function actionIndex()
    {
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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new JobOrderMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new JobOrderMaster();
        $model_details = new JobOrderDetails();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'model_details' => $model_details,
            ]);
        }
    }

    /**
     * Updates an existing JobOrderMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
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
    public function actionDelete($id)
    {
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
    protected function findModel($id)
    {
        if (($model = JobOrderMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionBottleDetails() {
        if (Yii::$app->request->isAjax) {
            $material_id = $_POST['material_id'];
            $stock= \common\models\StockView::find()->where(['material_id'=>$material_id])->one();
            $stock_val = 0;
            if(!empty($stock)){
                $stock_val = $stock->available_qty;
            }
            return $stock_val;
        }
    }
}
