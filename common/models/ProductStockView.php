<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_stock_view".
 *
 * @property int $id
 * @property int $product_id
 * @property string $available_qty
 * @property int $unit
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property FinishedProduct $product
 * @property Unit $unit0
 */
class ProductStockView extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_stock_view';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'available_qty', 'unit', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinishedProduct::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['unit'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['unit' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'available_qty' => 'Available Qty',
            'unit' => 'Unit',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(FinishedProduct::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit0()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit']);
    }
}
