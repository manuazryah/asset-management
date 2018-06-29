<?php

namespace backend\modules\product\controllers;

use Yii;
use common\models\FinishedProduct;
use common\models\FinishedProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\BomDetails;

/**
 * FinishedProductController implements the CRUD actions for FinishedProduct model.
 */
class FinishedProductController extends Controller {

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
     * Lists all FinishedProduct models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new FinishedProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FinishedProduct model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FinishedProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new FinishedProduct();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            $files = UploadedFile::getInstance($model, 'item_photo');
            if (!empty($files)) {
                $model->item_photo = $files->extension;
            }
            if ($model->validate() && $model->save()) {
                if (!empty($files)) {
                    $this->upload($model, $files);
                }
                return $this->redirect(['add', 'id' => $model->id]);
            }
        } return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Upload Material photos.
     * @return mixed
     */
    public function Upload($model, $files) {
        if (isset($files) && !empty($files)) {
            $files->saveAs(Yii::$app->basePath . '/../uploads/finished_product/' . $model->id . '.' . $files->extension);
        }
        return TRUE;
    }

    /**
     * Updates an existing FinishedProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $photo_ = $model->item_photo;
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            $files = UploadedFile::getInstance($model, 'item_photo');

            if (empty($files)) {
                $model->item_photo = $photo_;
            } else {
                $model->item_photo = $files->extension;
            }
            if ($model->validate() && $model->save()) {
                if (!empty($files)) {
                    $this->upload($model, $files);
                }
            }
        } return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /*
     * Add services to appointment
     */

    public function actionAdd($id, $prfrma_id = NULL) {

        if (!isset($prfrma_id)) {
            $model = new BomDetails();
        } else {
            $model = BomDetails::findOne($prfrma_id);
        }
        $bom_details = BomDetails::findAll(['finished_product_id' => $id]);
        $finished_product = FinishedProduct::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->finished_product_id = $id;
            $row_material = \common\models\SupplierwiseRowMaterial::findOne($model->row_material_id);
            $model->unit = $row_material->item_unit;
            if ($model->save()) {
                return $this->redirect(['add', 'id' => $id]);
            }
        }

        return $this->render('add', [
                    'model' => $model,
                    'bom_details' => $bom_details,
                    'finished_product' => $finished_product,
                    'id' => $id,
        ]);
    }

    /*
     * Delete service in appointment
     */

    public function actionDeleteDetail($id) {
        $bom_details = BomDetails::findOne($id);
        if (!empty($bom_details)) {
            $finished_product = FinishedProduct::find()->where(['id' => $bom_details->finished_product_id])->one();
            $bom_details->delete();
            return $this->redirect(['add', 'id' => $finished_product->id]);
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Deletes an existing FinishedProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FinishedProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FinishedProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = FinishedProduct::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetUnit() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['item_id'];
            $result = '';
            $supplier_material = \common\models\SupplierwiseRowMaterial::find()->where(['id' => $id])->one();
            if (!empty($supplier_material)) {
                if ($supplier_material->item_unit != '') {
                    $result = \common\models\Unit::findOne($supplier_material->item_unit)->unit_name;
                }
            }
            echo $result;
        }
    }

    public function actionGetDeleteDetail($id) {
        $model = BomDetails::find()->where(['id' => $id])->one();
        if (!empty($model)) {
            $model->delete();
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /*
     * This function get row material based on material category change
     * return row material
     */

    public function actionGetMaterial() {
        if (Yii::$app->request->isAjax) {
            $product_id = $_POST['product_id'];
            $category = $_POST['category'];
            $bom_details = BomDetails::findAll(['finished_product_id' => $product_id]);
            $deselct_ids = [];
            if (!empty($bom_details)) {
                foreach ($bom_details as $bom_detail) {
                    $deselct_ids[] = $bom_detail->row_material_id;
                }
            }
            $romaterial_datas = \common\models\SupplierwiseRowMaterial::find()->where(['status' => 1, 'material_ctegory' => $category])->andFilterWhere(['NOT IN', 'id', $deselct_ids])->all();
            $options = '<option value="">-Choose a Material-</option>';
            foreach ($romaterial_datas as $romaterial_data) {
                $options .= "<option value='" . $romaterial_data->id . "'>" . ucfirst($romaterial_data->item_name) . ' ( ' . $romaterial_data->item_code . ' )' . "</option>";
            }
            return $options;
        }
    }

}
