<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "material_adjustment_master".
 *
 * @property int $id
 * @property int $transaction 0->opening,1->addition,2->deduction
 * @property string $document_no
 * @property string $document_date
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property int $DOC
 * @property string $DOU
 *
 * @property MaterialAdjustmentDetails[] $materialAdjustmentDetails
 */
class MaterialAdjustmentMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'material_adjustment_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transaction', 'status', 'CB', 'UB', 'DOC'], 'integer'],
            [['document_date', 'DOU'], 'safe'],
            [['document_no'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaction' => 'Transaction',
            'document_no' => 'Document No',
            'document_date' => 'Document Date',
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
    public function getMaterialAdjustmentDetails()
    {
        return $this->hasMany(MaterialAdjustmentDetails::className(), ['master_id' => 'id']);
    }
}
