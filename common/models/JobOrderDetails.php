<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "job_order_details".
 *
 * @property int $id
 * @property int $master_id
 * @property int $named_bottle
 * @property int $quantity
 * @property string $comment
 * @property int $bottle
 * @property int $qty
 * @property int $damaged
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property JobOrderMaster $master
 * @property SupplierwiseRowMaterial $namedBottle
 * @property SupplierwiseRowMaterial $bottle0
 */
class JobOrderDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_order_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['named_bottle','bottle', 'qty','quantity'], 'required'],
            [['master_id', 'named_bottle', 'quantity', 'bottle', 'qty', 'damaged', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['comment'], 'string', 'max' => 1000],
            ['qty', 'compare', 'compareValue' => 0, 'operator' => '>'],
            ['quantity', 'compare', 'compareAttribute' => 'qty', 'operator' => '<='],
            [['master_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobOrderMaster::className(), 'targetAttribute' => ['master_id' => 'id']],
            [['named_bottle'], 'exist', 'skipOnError' => true, 'targetClass' => SupplierwiseRowMaterial::className(), 'targetAttribute' => ['named_bottle' => 'id']],
            [['bottle'], 'exist', 'skipOnError' => true, 'targetClass' => SupplierwiseRowMaterial::className(), 'targetAttribute' => ['bottle' => 'id']],
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
            'named_bottle' => 'Printed Bottle',
            'quantity' => 'Quantity',
            'comment' => 'Comment',
            'bottle' => 'Clear Bottle',
            'qty' => 'Qty',
            'damaged' => 'Damaged',
            'status' => 'Status',
            'CB' => 'CB',
            'UB' => 'UB',
            'DOC' => 'DOC',
            'DOU' => 'DOU',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaster()
    {
        return $this->hasOne(JobOrderMaster::className(), ['id' => 'master_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNamedBottle()
    {
        return $this->hasOne(SupplierwiseRowMaterial::className(), ['id' => 'named_bottle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBottle0()
    {
        return $this->hasOne(SupplierwiseRowMaterial::className(), ['id' => 'bottle']);
    }
}
