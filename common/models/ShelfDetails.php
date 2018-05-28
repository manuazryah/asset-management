<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shelf_details".
 *
 * @property int $id
 * @property string $shelf_name
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property PurchaseDetails[] $purchaseDetails
 * @property StockRegister[] $stockRegisters
 */
class ShelfDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shelf_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['shelf_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shelf_name' => 'Shelf Name',
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
        return $this->hasMany(PurchaseDetails::className(), ['shelf' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStockRegisters()
    {
        return $this->hasMany(StockRegister::className(), ['shelf' => 'id']);
    }
}
