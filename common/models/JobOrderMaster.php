<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "job_order_master".
 *
 * @property int $id
 * @property string $bom_no
 * @property string $bom_date
 * @property string $comment
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property JobOrderDetails[] $jobOrderDetails
 */
class JobOrderMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_order_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bom_date', 'bom_no'], 'required'],
            [['bom_date', 'DOC', 'DOU'], 'safe'],
            [['status', 'CB', 'UB'], 'integer'],
            [['bom_no'], 'string', 'max' => 100],
            [['comment'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bom_no' => 'Bom No',
            'bom_date' => 'Bom Date',
            'comment' => 'Comment',
            'status' => 'Status',
            'CB' => 'C B',
            'UB' => 'U B',
            'DOC' => 'D O C',
            'DOU' => 'D O U',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobOrderDetails()
    {
        return $this->hasMany(JobOrderDetails::className(), ['master_id' => 'id']);
    }
}
