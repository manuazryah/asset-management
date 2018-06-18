<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_stock_register".
 *
 * @property int $id
 * @property int $product_id
 * @property string $stock_in
 * @property string $stock_out
 * @property int $warehouse
 * @property int $unit
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property FinishedProduct $product
 * @property Warehouse $warehouse0
 * @property Unit $unit0
 */
class ProductStockRegister extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_stock_register';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'stock_in', 'stock_out', 'warehouse', 'unit', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinishedProduct::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['warehouse'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::className(), 'targetAttribute' => ['warehouse' => 'id']],
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
            'stock_in' => 'Stock In',
            'stock_out' => 'Stock Out',
            'warehouse' => 'Warehouse',
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
    public function getWarehouse0()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'warehouse']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit0()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit']);
    }
}
