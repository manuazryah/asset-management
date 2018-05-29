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
        $model = $this->findModel($id);
        $bom_details = \common\models\Bom::find()->where(['master_id'=>$model->id])->all();
        return $this->render('view', [
                    'model' => $model,
                    'bom_details' => $bom_details,
        ]);
    }

    /**
     * Creates a new BomMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new BomMaster();

        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post();
            $model->date = date("Y-m-d", strtotime($model->date));
            Yii::$app->SetValues->Attributes($model);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->save() && $this->SaveBomDetails($model, $data)) {
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
            ]);
        }
    }

    /*
     * Save BOM details
     */

    public function SaveBomDetails($model, $data) {
        $flag = 0;
        if (!empty($data['creatematerial'])) {
            foreach ($data['create'] as $key => $create) {
                if (!empty($data['creatematerial'][$key])) {
                    if ($this->BomCreate($model, $create, $key, $data['creatematerial'][$key])) {
                        $flag = 1;
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

    /**
     * To set sales details into an array.
     */
    public function BomCreate($model, $create, $key, $creatematerial) {
        $flag = 0;
        if ($create['product'] != '' && $create['product_qty'] != '' && $create['product_qty'] > 0) {
            $bom_details = new \common\models\Bom();
            $bom_details->master_id = $model->id;
            $bom_details->product = $create['product'];
            $bom_details->qty = $create['product_qty'];
            $bom_details->comment = $create['product_comment'];
            Yii::$app->SetValues->Attributes($bom_details);
            if ($bom_details->save()) {
                if ($this->BomMaterial($model, $bom_details, $key, $creatematerial)) {
                    $flag = 1;
                }
            }
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * To set sales details into an array.
     */
    public function BomMaterial($model, $bom_details, $key, $creatematerial) {
        $flag = 0;
        if (isset($creatematerial) && $creatematerial != '') {
            $arr = [];
            $i = 0;
            if (!empty($creatematerial['material_id'])) {
                foreach ($creatematerial['material_id'] as $val) {
                    $arr[$i]['material_id'] = $val;
                    $i++;
                }
            }
            $i = 0;
            if (!empty($creatematerial['material_qty'])) {
                foreach ($creatematerial['material_qty'] as $val) {
                    $arr[$i]['material_qty'] = $val;
                    $i++;
                }
            }
            $i = 0;
            if (!empty($creatematerial['material_comment'])) {
                foreach ($creatematerial['material_comment'] as $val) {
                    $arr[$i]['material_comment'] = $val;
                    $i++;
                }
            }
            if ($this->AddMaterialDetails($arr, $bom_details)) {
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
     * This function save material details.
     */
    public function AddMaterialDetails($arr, $bom_details) {
        $flag = 0;
        foreach ($arr as $val) {
            $aditional = new \common\models\BomMaterialDetails();
            $aditional->bom_id = $bom_details->id;
            $aditional->material = $val['material_id'];
            $aditional->quantity = $val['material_qty'];
            $aditional->comment = $val['material_comment'];
            Yii::$app->SetValues->Attributes($aditional);
            if ($aditional->save()) {
                $flag = 1;
            } else {
                $flag = 0;
            }
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
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
            $current_row_id = $_POST['current_row_id'];
            $finished_products = \common\models\FinishedProduct::find()->where(['id' => $item_id])->one();
            $material_details = \common\models\BomDetails::find()->where(['finished_product_id' => $finished_products->id])->all();
            $supplier_materials = \common\models\SupplierwiseRowMaterial::find()->all();
            $new_row = $this->renderPartial('material_row', [
                'finished_products' => $finished_products,
                'material_details' => $material_details,
                'current_row_id' => $current_row_id,
                'supplier_materials' => $supplier_materials,
            ]);
            $arr_variable1 = array('new_row' => $new_row, 'product_comment' => $finished_products->comment);
            $data['result'] = $arr_variable1;
            return json_encode($data);
        }
    }

    public function getBomNo() {
        $bom_last = BomMaster::find()->orderBy(['id' => SORT_DESC])->one();
        if (!empty($bom_last)) {
            $num = $bom_last->id + 1;
        } else {
            $num = 1;
        }
        return 'BOM' . $num;
    }

}
