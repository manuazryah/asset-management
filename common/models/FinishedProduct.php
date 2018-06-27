<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "finished_product".
 *
 * @property int $id
 * @property int $product_category
 * @property string $product_name
 * @property string $product_code
 * @property string $item_photo
 * @property int $fragrance_type
 * @property string $price
 * @property int $brand
 * @property int $size
 * @property int $unit
 * @property int $gender
 * @property string $reference
 * @property string $comment
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property BomDetails[] $bomDetails
 * @property ProductCategory $productCategory
 * @property Fragrance $fragranceType
 * @property Unit $unit0
 * @property Brand $brand0
 */
class FinishedProduct extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'finished_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['product_category', 'fragrance_type', 'brand', 'size', 'unit', 'gender', 'status', 'CB', 'UB'], 'integer'],
                [['price'], 'number'],
                [['comment'], 'string'],
                [['DOC', 'DOU'], 'safe'],
                [['product_name', 'product_code', 'item_photo'], 'string', 'max' => 100],
                [['reference'], 'string', 'max' => 500],
                [['product_category'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['product_category' => 'id']],
                [['fragrance_type'], 'exist', 'skipOnError' => true, 'targetClass' => Fragrance::className(), 'targetAttribute' => ['fragrance_type' => 'id']],
                [['unit'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['unit' => 'id']],
                [['brand'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand' => 'id']],
                [['product_category', 'product_name', 'fragrance_type', 'brand', 'size', 'unit', 'price'], 'required'],
                [['item_photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, bmp'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'product_category' => 'Product Category',
            'product_name' => 'Product Name',
            'product_code' => 'Product Code',
            'item_photo' => 'Item Photo',
            'fragrance_type' => 'Fragrance Type',
            'price' => 'Price',
            'brand' => 'Brand',
            'size' => 'Size',
            'unit' => 'Unit',
            'gender' => 'Gender',
            'reference' => 'Reference',
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
    public function getBomDetails() {
        return $this->hasMany(BomDetails::className(), ['finished_product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCategory() {
        return $this->hasOne(ProductCategory::className(), ['id' => 'product_category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFragranceType() {
        return $this->hasOne(Fragrance::className(), ['id' => 'fragrance_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit0() {
        return $this->hasOne(Unit::className(), ['id' => 'unit']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand0() {
        return $this->hasOne(Brand::className(), ['id' => 'brand']);
    }

}
