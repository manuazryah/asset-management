<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "purchase_details".
 *
 * @property int $id
 * @property int $master_id
 * @property int $material
 * @property int $qty
 * @property string $price
 * @property string $total
 * @property string $comment
 * @property int $warehouse
 * @property int $shelf
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property PurchaseMaster $master
 * @property SupplierwiseRowMaterial $material0
 * @property Warehouse $warehouse0
 * @property ShelfDetails $shelf0
 */
class PurchaseDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchase_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_id', 'material', 'qty', 'warehouse', 'shelf', 'status', 'CB', 'UB'], 'integer'],
            [['price', 'total'], 'number'],
            [['comment'], 'string'],
            [['DOC', 'DOU'], 'safe'],
            [['master_id'], 'exist', 'skipOnError' => true, 'targetClass' => PurchaseMaster::className(), 'targetAttribute' => ['master_id' => 'id']],
            [['material'], 'exist', 'skipOnError' => true, 'targetClass' => SupplierwiseRowMaterial::className(), 'targetAttribute' => ['material' => 'id']],
            [['warehouse'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::className(), 'targetAttribute' => ['warehouse' => 'id']],
//            [['shelf'], 'exist', 'skipOnError' => true, 'targetClass' => ShelfDetails::className(), 'targetAttribute' => ['shelf' => 'id']],
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
            'qty' => 'Qty',
            'price' => 'Price',
            'total' => 'Total',
            'comment' => 'Comment',
            'warehouse' => 'Warehouse',
            'shelf' => 'Shelf',
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
        return $this->hasOne(PurchaseMaster::className(), ['id' => 'master_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial0()
    {
        return $this->hasOne(SupplierwiseRowMaterial::className(), ['id' => 'material']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse0()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'warehouse']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getShelf0()
//    {
//        return $this->hasOne(ShelfDetails::className(), ['id' => 'shelf']);
//    }
}
