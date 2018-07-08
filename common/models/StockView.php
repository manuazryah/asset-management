<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock_view".
 *
 * @property int $id
 * @property int $material_id
 * @property string $available_qty
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property SupplierwiseRowMaterial $material
 */
class StockView extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'stock_view';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['material_id', 'available_qty', 'status', 'CB', 'UB', 'reserved_qty'], 'integer'],
                [['DOC', 'DOU'], 'safe'],
                [['material_id'], 'exist', 'skipOnError' => true, 'targetClass' => SupplierwiseRowMaterial::className(), 'targetAttribute' => ['material_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'material_id' => 'Material ID',
            'available_qty' => 'Available Qty',
            'status' => 'Status',
            'reserved_qty' => 'Reserved Quantity',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial() {
        return $this->hasOne(SupplierwiseRowMaterial::className(), ['id' => 'material_id']);
    }

}
