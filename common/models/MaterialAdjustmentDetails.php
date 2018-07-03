<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "material_adjustment_details".
 *
 * @property int $id
 * @property int $master_id
 * @property int $material_id
 * @property int $qty
 * @property string $price
 * @property string $total
 * @property int $warehouse
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property MaterialAdjustmentMaster $master
 * @property SupplierwiseRowMaterial $material
 * @property Warehouse $warehouse0
 */
class MaterialAdjustmentDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'material_adjustment_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_id', 'material_id', 'qty', 'warehouse', 'status', 'CB', 'UB'], 'integer'],
            [['price', 'total'], 'number'],
            [['DOC', 'DOU'], 'safe'],
            [['master_id'], 'exist', 'skipOnError' => true, 'targetClass' => MaterialAdjustmentMaster::className(), 'targetAttribute' => ['master_id' => 'id']],
            [['material_id'], 'exist', 'skipOnError' => true, 'targetClass' => SupplierwiseRowMaterial::className(), 'targetAttribute' => ['material_id' => 'id']],
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
            'material_id' => 'Material ID',
            'qty' => 'Qty',
            'price' => 'Price',
            'total' => 'Total',
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
        return $this->hasOne(MaterialAdjustmentMaster::className(), ['id' => 'master_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(SupplierwiseRowMaterial::className(), ['id' => 'material_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse0()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'warehouse']);
    }
}
