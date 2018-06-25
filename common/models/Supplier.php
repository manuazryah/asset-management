<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property int $id
 * @property string $company_name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $contact_person
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class Supplier extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['address'], 'string'],
                [['status', 'CB', 'UB', 'type'], 'integer'],
                [['DOC', 'DOU'], 'safe'],
                [['company_name', 'email', 'contact_person'], 'string', 'max' => 100],
                [['phone'], 'string', 'max' => 20],
                [['company_name', 'email', 'phone', 'address'], 'required'],
                [['email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'contact_person' => 'Contact Person',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

}
