<?php

namespace backend\modules\sales\controllers;

use Yii;
use common\models\ProductSaleMaster;
use common\models\ProductSaleMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductSaleMasterController implements the CRUD actions for ProductSaleMaster model.
 */
class ProductSaleMasterController extends Controller
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
     * Lists all ProductSaleMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductSaleMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
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
            var_dump($data);exit;
            $model_stock_master = $this->SaveStockMaster($model_stock_master, $data, $flag);
            $arr = $this->SaveStockDetails($model_stock_master, $data, $flag);
            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($model_stock_master->save() && $this->AddStockDetails($arr, $model_stock_master, $flag)) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('add', [
                    'model' => $model,
                    'model_master' => $model_master,
        ]);
    }

    /**
     * Updates an existing ProductSaleMaster model.
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
     * Deletes an existing ProductSaleMaster model.
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
     * Finds the ProductSaleMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductSaleMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductSaleMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
