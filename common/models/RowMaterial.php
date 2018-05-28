<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "row_material".
 *
 * @property int $id
 * @property int $category
 * @property string $item_code
 * @property string $item_name
 * @property int $item_unit
 * @property string $photo
 * @property string $reference
 * @property string $description
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property BomDetails[] $bomDetails
 * @property RowMaterialCategory $category0
 * @property Unit $itemUnit
 * @property SupplierwiseRowMaterial[] $supplierwiseRowMaterials
 */
class RowMaterial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'row_material';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category', 'item_unit', 'status', 'CB', 'UB'], 'integer'],
            [['description'], 'string'],
            [['DOC', 'DOU'], 'safe'],
            [['item_code', 'item_name', 'photo'], 'string', 'max' => 100],
            [['reference'], 'string', 'max' => 500],
            [['category','item_code', 'item_name','item_unit'], 'required'],
            [['photo'], 'required', 'on' => 'create'],
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => RowMaterialCategory::className(), 'targetAttribute' => ['category' => 'id']],
            [['item_unit'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['item_unit' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'item_code' => 'Item Code',
            'item_name' => 'Item Name',
            'item_unit' => 'Item Unit',
            'photo' => 'Photo',
            'reference' => 'Reference',
            'description' => 'Description',
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
    public function getBomDetails()
    {
        return $this->hasMany(BomDetails::className(), ['master_row_material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory0()
    {
        return $this->hasOne(RowMaterialCategory::className(), ['id' => 'category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'item_unit']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupplierwiseRowMaterials()
    {
        return $this->hasMany(SupplierwiseRowMaterial::className(), ['master_row_material_id' => 'id']);
    }
}
