<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admin_posts".
 *
 * @property integer $id
 * @property string $post_name
 * @property integer $status
 * @property integer $CB
 * @property integer $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property AdminUsers[] $adminUsers
 */
class AdminPosts extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'admin_posts';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['post_name'], 'required'],
                [['status', 'CB', 'UB', 'admin', 'masters', 'purchase', 'stock', 'bom', 'supplier_customer', 'sale'], 'integer'],
                [['DOC', 'DOU'], 'safe'],
                [['post_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'post_name' => 'Post Name',
            'status' => 'Status',
            'admin' => 'Admin',
            'masters' => 'Masters',
            'purchase' => 'Purchase',
            'stock' => 'Stock',
            'bom' => 'BOM',
            'supplier_customer' => 'Suppliers & Customers',
            'CB' => 'Created By',
            'UB' => 'Updated By',
            'DOC' => 'Date of Creation',
            'DOU' => 'Date of Updation',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminUsers() {
        return $this->hasMany(AdminUsers::className(), ['post_id' => 'id']);
    }

}
