<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_adjustment_details".
 *
 * @property int $id
 * @property int $master_id
 * @property int $product
 * @property int $quantity
 * @property int $unit
 * @property int $warehouse
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property ProductAdjustmentMaster $master
 * @property FinishedProduct $product0
 * @property Unit $unit0
 * @property Warehouse $warehouse0
 */
class ProductAdjustmentDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_adjustment_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_id', 'product', 'quantity', 'unit', 'warehouse', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['master_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductAdjustmentMaster::className(), 'targetAttribute' => ['master_id' => 'id']],
            [['product'], 'exist', 'skipOnError' => true, 'targetClass' => FinishedProduct::className(), 'targetAttribute' => ['product' => 'id']],
            [['unit'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['unit' => 'id']],
            [['warehouse'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::className(), 'targetAttribute' => ['warehouse' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'master_id' => 'Master ID',
            'product' => 'Product',
            'quantity' => 'Quantity',
            'unit' => 'Unit',
            'warehouse' => 'Warehouse',
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
    public function getMaster()
    {
        return $this->hasOne(ProductAdjustmentMaster::className(), ['id' => 'master_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct0()
    {
        return $this->hasOne(FinishedProduct::className(), ['id' => 'product']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit0()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse0()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'warehouse']);
    }
}
