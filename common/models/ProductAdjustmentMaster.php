<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_adjustment_master".
 *
 * @property int $id
 * @property string $document_no
 * @property string $document_date
 * @property int $transaction 0->opening,1->addition,2->deduction
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property ProductAdjustmentDetails[] $productAdjustmentDetails
 */
class ProductAdjustmentMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_adjustment_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['document_date', 'DOC', 'DOU'], 'safe'],
            [['document_date', 'document_no', 'transaction'], 'required'],
            [['transaction', 'status', 'CB', 'UB'], 'integer'],
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
            'document_no' => 'Document No',
            'document_date' => 'Document Date',
            'transaction' => 'Transaction',
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
    public function getProductAdjustmentDetails()
    {
        return $this->hasMany(ProductAdjustmentDetails::className(), ['master_id' => 'id']);
    }
}
