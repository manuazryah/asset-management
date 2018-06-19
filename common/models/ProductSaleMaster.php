<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_sale_master".
 *
 * @property int $id
 * @property string $date
 * @property string $invoice_no
 * @property string $comment
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property ProductSaleDetails[] $productSaleDetails
 */
class ProductSaleMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_sale_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'status', 'CB', 'UB'], 'integer'],
            [['date', 'DOC', 'DOU'], 'safe'],
            [['invoice_no'], 'string', 'max' => 100],
            [['comment'], 'string', 'max' => 500],
            [['id'], 'unique'],
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
    public function getProductSaleDetails()
    {
        return $this->hasMany(ProductSaleDetails::className(), ['master_id' => 'id']);
    }
}
