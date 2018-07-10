<?php

namespace backend\modules\masters\controllers;

use Yii;
use common\models\Warehouse;
use common\models\WarehouseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WarehouseController implements the CRUD actions for Warehouse model.
 */
class WarehouseController extends Controller {

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
//                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Warehouse models.
     * @return mixed
     */
    public function actionIndex($id = null) {
        $searchModel = new WarehouseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (isset($id) && $id != '')
            $model = $this->findModel($id);
        else
            $model = new Warehouse();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            if ($model->set_as_default == 1) {
                $exist = Warehouse::find()->where(['set_as_default' => 1])->one();
                if (!empty($exist)) {
                    $exist->set_as_default = 0;
                    $exist->update();
                }
            }
            $model->warehouse_name = ucfirst($model->warehouse_name);
            if ($model->save()) {
                if (isset($id) && $id != '')
                    Yii::$app->session->setFlash('success', "Warehouse Updated Successfully");
                else
                    Yii::$app->session->setFlash('success', "Warehouse Created Successfully");
                $model = new Warehouse();
                return $this->redirect(['index']);
            }
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    /**
     * Displays a single Warehouse model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Warehouse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Warehouse();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Warehouse model.
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
     * Deletes an existing Warehouse model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        try {
            if ($this->findModel($id)->delete()) {
                Yii::$app->session->setFlash('success', "Warehouse removed Successfully");
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', "Can't delete. Because this warehouse is used in another functions.");
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Warehouse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Warehouse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Warehouse::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
