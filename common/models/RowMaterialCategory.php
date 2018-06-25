<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "row_material_category".
 *
 * @property int $id
 * @property string $category
 * @property string $photo
 * @property int $status
 * @property string $comment
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class RowMaterialCategory extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'row_material_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['status', 'CB', 'UB'], 'integer'],
                [['comment'], 'string'],
                [['DOC', 'DOU'], 'safe'],
                [['category'], 'required'],
                [['category', 'photo'], 'string', 'max' => 100],
//            [['photo','category'], 'required', 'on' => 'create'],
//            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'photo' => 'Photo',
            'status' => 'Status',
            'comment' => 'Comment',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

}
