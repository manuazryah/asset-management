<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "purchase_master".
 *
 * @property int $id
 * @property string $date
 * @property string $invoice_no
 * @property int $supplier
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property PurchaseDetails[] $purchaseDetails
 * @property Supplier $supplier0
 */
class PurchaseMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchase_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'DOC', 'DOU'], 'safe'],
            [['supplier', 'status', 'CB', 'UB'], 'integer'],
            [['date', 'invoice_no', 'supplier'], 'required'],
            [['invoice_no'], 'string', 'max' => 100],
            [['supplier'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['supplier' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'invoice_no' => 'Invoice No',
            'supplier' => 'Supplier',
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
    public function getPurchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::className(), ['master_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier0()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier']);
    }
}
