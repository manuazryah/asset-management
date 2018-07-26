<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock_register".
 *
 * @property int $id
 * @property int $type 1->purchase
 * @property int $document_line_id
 * @property string $invoice_no
 * @property string $invoice_date
 * @property int $item_id
 * @property string $item_code
 * @property string $item_name
 * @property int $warehouse
 * @property int $shelf
 * @property string $item_cost
 * @property string $weight_in
 * @property string $weight_out
 * @property string $balance_qty
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property SupplierwiseRowMaterial $item
 * @property Warehouse $warehouse0
 * @property ShelfDetails $shelf0
 */
class StockRegister extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'stock_register';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['type', 'document_line_id', 'item_id', 'warehouse', 'shelf', 'weight_in', 'weight_out', 'balance_qty', 'status', 'CB', 'UB','damaged_quantity'], 'integer'],
                [['invoice_date', 'DOC', 'DOU'], 'safe'],
                [['item_cost'], 'number'],
                [['invoice_no', 'item_code', 'item_name'], 'string', 'max' => 100],
                [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => SupplierwiseRowMaterial::className(), 'targetAttribute' => ['item_id' => 'id']],
                [['warehouse'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::className(), 'targetAttribute' => ['warehouse' => 'id']],
                [['shelf'], 'exist', 'skipOnError' => true, 'targetClass' => ShelfDetails::className(), 'targetAttribute' => ['shelf' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'document_line_id' => 'Document Line ID',
            'invoice_no' => 'Invoice No',
            'invoice_date' => 'Invoice Date',
            'item_id' => 'Item ID',
            'item_code' => 'Item Code',
            'item_name' => 'Item Name',
            'warehouse' => 'Warehouse',
            'shelf' => 'Shelf',
            'item_cost' => 'Item Cost',
            'weight_in' => 'Stock In',
            'weight_out' => 'Stock Out',
            'balance_qty' => 'Balance Qty',
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
    public function getItem() {
        return $this->hasOne(SupplierwiseRowMaterial::className(), ['id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse0() {
        return $this->hasOne(Warehouse::className(), ['id' => 'warehouse']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShelf0() {
        return $this->hasOne(ShelfDetails::className(), ['id' => 'shelf']);
    }

}
