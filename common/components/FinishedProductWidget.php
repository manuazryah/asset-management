<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppointmentWidget
 *
 * @author 
 * JIthin Wails
 */


namespace common\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use common\models\FinishedProduct;

class FinishedProductWidget extends Widget{
	public $id;
	
	public function init(){
		parent::init();
		if($this->id===null){
			throw new \yii\web\HttpException(404, 'Invalid appintment.Eroor Code:1005');
		}
	}
	
	public function run(){
                $product = FinishedProduct::findOne($this->id);
                return $this->render('finished_product',['product'=>$product]);
		//return Html::encode($this->message);
	}
}
?>
