<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_sale_details".
 *
 * @property int $id
 * @property int $master_id
 * @property int $material
 * @property string $quantity
 * @property string $unit
 * @property string $comment
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property ProductSaleMaster $master
 */
class ProductSaleDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_sale_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_id', 'material', 'quantity', 'status', 'CB', 'UB','warehouse'], 'integer'],
            [['DOC', 'DOU','unit'], 'safe'],
            [['comment'], 'string', 'max' => 500],
            [['master_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductSaleMaster::className(), 'targetAttribute' => ['master_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'master_id' => 'Master ID',
            'material' => 'Material',
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
    public function getMaster()
    {
        return $this->hasOne(ProductSaleMaster::className(), ['id' => 'master_id']);
    }
}
