<?php

namespace backend\modules\reports\controllers;

use Yii;
use common\models\PurchaseDetailsSearch;

class PurchaseReportController extends \yii\web\Controller {

    public function actionIndex() {
        $searchModel = new PurchaseDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
