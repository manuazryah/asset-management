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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
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
                $item_datas = \common\models\SupplierwiseRowMaterial::find()->where(['id' => $item_id])->one();
                $row_material = \common\models\RowMaterial::find()->where(['id' => $item_datas->master_row_material_id])->one();
                if (!empty($item_datas)) {
                    $price = $item_datas->purchase_price;
                    if (!empty($row_material)) {
                        $unit = $row_material->item_unit != '' ? \common\models\Unit::findOne($row_material->item_unit)->unit_name : '';
                    }
                }
                $arr_variable1 = array('unit' => $unit, 'price' => $price);
                $data1['result'] = $arr_variable1;
                return json_encode($data1);
            }
        }
    }

}
