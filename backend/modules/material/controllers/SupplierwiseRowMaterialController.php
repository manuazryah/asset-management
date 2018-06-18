<?php

namespace backend\modules\material\controllers;

use Yii;
use common\models\SupplierwiseRowMaterial;
use common\models\SupplierwiseRowMaterialSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SupplierwiseRowMaterialController implements the CRUD actions for SupplierwiseRowMaterial model.
 */
class SupplierwiseRowMaterialController extends Controller {
    
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
     * Lists all SupplierwiseRowMaterial models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SupplierwiseRowMaterialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SupplierwiseRowMaterial model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SupplierwiseRowMaterial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new SupplierwiseRowMaterial();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            $check = Yii::$app->request->post('check');
            $files = UploadedFile::getInstance($model, 'photo');
            if (!empty($files)) {
                $model->photo = $files->extension;
            }
            if ($model->validate() && $model->save()) {
                if (!empty($files)) {
                    $this->upload($model, $files);
                } else {
                    if ($check == 1) {
                        $this->copyImage($model);
                    }
                }
                Yii::$app->session->setFlash('success', "Supplier wise Row Material Created Successfully");
                $model = new SupplierwiseRowMaterial();
            }
        }
            return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Upload Material photos.
     * @return mixed
     */
    public function Upload($model, $files) {
        if (isset($files) && !empty($files)) {
            $files->saveAs(Yii::$app->basePath . '/../uploads/supplierwise_material/' . $model->id . '.' . $files->extension);
        }
        return TRUE;
    }

    /**
     * Upload Material photos.
     * @return mixed
     */
    public function copyImage($model) {
        $row_material = \common\models\RowMaterial::findOne($model->master_row_material_id);
        $download_image = Yii::$app->basePath . '/../uploads/row_material/' . $row_material->id . '.' . $row_material->photo;
        $image_id = $model->id;
        $original_name = basename($download_image);
        $original_extension = substr($original_name, strrpos($original_name, '.'));
        $types = array(
            'image/jpeg' => '.jpg',
            'image/png' => '.png',
        );
        $img = file_get_contents($download_image);
        $path = Yii::$app->basePath . '/../uploads/supplierwise_material/';
        $stored_name = $path . $image_id . $original_extension;
        if ($img) {
            file_put_contents($stored_name, $img);
            $size = filesize($stored_name);
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimetype = finfo_file($finfo, $stored_name);
            if (isset($types[$mimetype])) {
                if ($types[$mimetype] != $original_extension) {
                    rename($stored_name, $path . $image_id . $types[$mimetype]);
                }
            }
            finfo_close($finfo);
        }
        $model->photo = ltrim($original_extension, '.');
        $model->update();
        return TRUE;
    }

    /**
     * Updates an existing SupplierwiseRowMaterial model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $photo_ = $model->photo;
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            $files = UploadedFile::getInstance($model, 'photo');
            $check = Yii::$app->request->post('check');
            if (empty($files)) {
                $model->photo = $photo_;
            } else {
                $model->photo = $files->extension;
            }
            if ($model->validate() && $model->save()) {
                if (!empty($files)) {
                    $this->upload($model, $files);
                }else {
                    if ($check == 1) {
                        $this->copyImage($model);
                    }
                }
                Yii::$app->session->setFlash('success', "Supplier wise Row Material Updated Successfully");
            }
        } return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SupplierwiseRowMaterial model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        try {
            if ($this->findModel($id)->delete()) {
                Yii::$app->session->setFlash('success', "Supplier wise Row Material removed Successfully");
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', "Can't delete. Because this row material is used in another functions.");
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the SupplierwiseRowMaterial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SupplierwiseRowMaterial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = SupplierwiseRowMaterial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetMaterialDetails() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['item_id'];
            $email = '';
            $row_material = \common\models\RowMaterial::find()->where(['id' => $id])->one();
            $item_name = '';
            $item_code = '';
            $item_unit = '';
            if (!empty($row_material)) {
                $item_name = $row_material->item_name;
                $item_code = $row_material->item_code;
                $item_unit = $row_material->item_unit;
            }
            $arrr_variable = array('item_name' => $item_name, 'item_code' => $item_code, 'item_unit' => $item_unit);
            $data['result'] = $arrr_variable;
            echo json_encode($data);
        }
    }

}
