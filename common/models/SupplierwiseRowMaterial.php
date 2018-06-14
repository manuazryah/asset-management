<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "supplierwise_row_material".
 *
 * @property int $id
 * @property int $master_row_material_id
 * @property string $item_code
 * @property string $item_name
 * @property int $item_unit
 * @property string $photo
 * @property string $reference
 * @property int $supplier
 * @property string $purchase_price
 * @property int $minimum_quantity
 * @property string $comment
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property BomDetails[] $bomDetails
 * @property RowMaterial $masterRowMaterial
 * @property Supplier $supplier0
 * @property Unit $itemUnit
 */
class SupplierwiseRowMaterial extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'supplierwise_row_material';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['master_row_material_id', 'item_unit', 'supplier', 'minimum_quantity', 'status', 'CB', 'UB'], 'integer'],
            [['purchase_price'], 'number'],
            [['comment'], 'string'],
            [['DOC', 'DOU'], 'safe'],
            [['item_code', 'item_name', 'photo', 'reference'], 'string', 'max' => 100],
            [['master_row_material_id'], 'exist', 'skipOnError' => true, 'targetClass' => RowMaterial::className(), 'targetAttribute' => ['master_row_material_id' => 'id']],
            [['supplier'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['supplier' => 'id']],
            [['item_unit'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['item_unit' => 'id']],
            [['item_code', 'item_name', 'master_row_material_id', 'item_unit', 'reference', 'minimum_quantity', 'purchase_price', 'supplier'], 'required'],
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'master_row_material_id' => 'Master Row Material ID',
            'item_code' => 'Item Code',
            'item_name' => 'Item Name',
            'item_unit' => 'Item Unit',
            'photo' => 'Photo',
            'reference' => 'Reference',
            'supplier' => 'Supplier',
            'purchase_price' => 'Purchase Price',
            'minimum_quantity' => 'Minimum Stock Quantity',
            'comment' => 'Comment',
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
    public function getBomDetails() {
        return $this->hasMany(BomDetails::className(), ['row_material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMasterRowMaterial() {
        return $this->hasOne(RowMaterial::className(), ['id' => 'master_row_material_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier0() {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemUnit() {
        return $this->hasOne(Unit::className(), ['id' => 'item_unit']);
    }

}
