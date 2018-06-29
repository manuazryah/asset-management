<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bom_details".
 *
 * @property int $id
 * @property int $finished_product_id
 * @property int $row_material_category
 * @property int $row_material_id
 * @property int $quantity
 * @property int $unit
 * @property string $comment
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property FinishedProduct $finishedProduct
 * @property SupplierwiseRowMaterial $rowMaterial
 * @property Unit $unit0
 * @property RowMaterialCategory $rowMaterialCategory
 */
class BomDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bom_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['finished_product_id', 'row_material_category', 'row_material_id', 'quantity', 'unit', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['comment'], 'string', 'max' => 500],
            [['row_material_id', 'quantity'], 'required'],
            [['finished_product_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinishedProduct::className(), 'targetAttribute' => ['finished_product_id' => 'id']],
            [['row_material_id'], 'exist', 'skipOnError' => true, 'targetClass' => SupplierwiseRowMaterial::className(), 'targetAttribute' => ['row_material_id' => 'id']],
            [['unit'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['unit' => 'id']],
            [['row_material_category'], 'exist', 'skipOnError' => true, 'targetClass' => RowMaterialCategory::className(), 'targetAttribute' => ['row_material_category' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'finished_product_id' => 'Finished Product ID',
            'row_material_category' => 'Row Material Category',
            'row_material_id' => 'Row Material ID',
            'quantity' => 'Quantity',
            'unit' => 'Unit',
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
    public function getFinishedProduct()
    {
        return $this->hasOne(FinishedProduct::className(), ['id' => 'finished_product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRowMaterial()
    {
        return $this->hasOne(SupplierwiseRowMaterial::className(), ['id' => 'row_material_id']);
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
    public function getRowMaterialCategory()
    {
        return $this->hasOne(RowMaterialCategory::className(), ['id' => 'row_material_category']);
    }
}
