<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bom_material_details".
 *
 * @property int $id
 * @property int $bom_id
 * @property int $material
 * @property string $quantity
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property Bom $bom
 */
class BomMaterialDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bom_material_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bom_id', 'material', 'quantity', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['bom_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bom::className(), 'targetAttribute' => ['bom_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bom_id' => 'Bom ID',
            'material' => 'Material',
            'quantity' => 'Quantity',
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
    public function getBom()
    {
        return $this->hasOne(Bom::className(), ['id' => 'bom_id']);
    }
}
