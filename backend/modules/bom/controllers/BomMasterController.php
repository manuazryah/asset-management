<?php

namespace backend\modules\bom\controllers;

use Yii;
use common\models\BomMaster;
use common\models\BomMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BomMasterController implements the CRUD actions for BomMaster model.
 */
class BomMasterController extends Controller {

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
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BomMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new BomMaster();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
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
     * This function find selected item details.
     * return item details as json array
     */
    public function actionGetItems() {
        if (Yii::$app->request->isAjax) {
            $item_id = $_POST['item_id'];
            $current_row_id= $_POST['current_row_id'];
            $finished_products = \common\models\FinishedProduct::find()->where(['id' => $item_id])->one();
            $material_details = \common\models\BomDetails::find()->where(['finished_product_id' => $finished_products->id])->all();
            $supplier_materials = \common\models\SupplierwiseRowMaterial::find()->all();
            $new_row = $this->renderPartial('material_row', [
                'finished_products' => $finished_products,
                'material_details' => $material_details,
                'current_row_id' => $current_row_id,
                'supplier_materials' => $supplier_materials,
            ]);
            return $new_row;
        }
    }

}
