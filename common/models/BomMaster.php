<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bom_master".
 *
 * @property int $id
 * @property string $bom_no
 * @property string $date
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property Bom[] $boms
 */
class BomMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bom_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'DOC', 'DOU'], 'safe'],
            [['date', 'bom_no'], 'required'],
            [['status', 'CB', 'UB'], 'integer'],
            [['bom_no'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bom_no' => 'BOM No',
            'date' => 'BOM Date',
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
    public function getBoms()
    {
        return $this->hasMany(Bom::className(), ['master_id' => 'id']);
    }
}
