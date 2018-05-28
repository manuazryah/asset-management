<?php

namespace backend\modules\masters\controllers;

use Yii;
use common\models\RowMaterialCategory;
use common\models\RowMaterialCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * RowMaterialCategoryController implements the CRUD actions for RowMaterialCategory model.
 */
class RowMaterialCategoryController extends Controller {

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
     * Lists all RowMaterialCategory models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new RowMaterialCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RowMaterialCategory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RowMaterialCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new RowMaterialCategory();
        $model->setScenario('create');
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            $files = UploadedFile::getInstance($model, 'photo');
            if (!empty($files)) {
                $model->photo = $files->extension;
            }
            if ($model->validate() && $model->save()) {
                if (!empty($files)) {
                    $this->upload($model, $files);
                }
                Yii::$app->session->setFlash('success', "Row Material Category Created Successfully");
                $model = new RowMaterialCategory();
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
            $files->saveAs(Yii::$app->basePath . '/../uploads/material_category/' . $model->id . '.' . $files->extension);
        }
        return TRUE;
    }

    /**
     * Updates an existing RowMaterialCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $photo_ = $model->photo;
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            $files = UploadedFile::getInstance($model, 'photo');

            if (empty($files)) {
                $model->photo = $photo_;
            } else {
                $model->photo = $files->extension;
            }
            if ($model->validate() && $model->save()) {
                if (!empty($files)) {
                    $this->upload($model, $files);
                }
                Yii::$app->session->setFlash('success', "Row Material Category Updated Successfully");
            }
        } return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RowMaterialCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
       try {
            if ($this->findModel($id)->delete()) {
                Yii::$app->session->setFlash('success', "Row Material Category removed Successfully");
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', "Can't delete. Because this row material category is used in another functions.");
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the RowMaterialCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RowMaterialCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = RowMaterialCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
