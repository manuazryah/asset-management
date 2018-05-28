<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bom".
 *
 * @property int $id
 * @property int $master_id
 * @property int $product
 * @property int $qty
 * @property string $comment
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property BomMaster $master
 * @property FinishedProduct $product0
 * @property BomMaterialDetails[] $bomMaterialDetails
 */
class Bom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_id', 'product', 'qty', 'status', 'CB', 'UB'], 'integer'],
            [['comment'], 'string'],
            [['DOC', 'DOU'], 'safe'],
            [['master_id'], 'exist', 'skipOnError' => true, 'targetClass' => BomMaster::className(), 'targetAttribute' => ['master_id' => 'id']],
            [['product'], 'exist', 'skipOnError' => true, 'targetClass' => FinishedProduct::className(), 'targetAttribute' => ['product' => 'id']],
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
            'product' => 'Product',
            'qty' => 'Qty',
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
        return $this->hasOne(BomMaster::className(), ['id' => 'master_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct0()
    {
        return $this->hasOne(FinishedProduct::className(), ['id' => 'product']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBomMaterialDetails()
    {
        return $this->hasMany(BomMaterialDetails::className(), ['bom_id' => 'id']);
    }
}
