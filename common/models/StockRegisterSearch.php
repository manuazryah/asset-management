<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StockRegister;

/**
 * StockRegisterSearch represents the model behind the search form about `common\models\StockRegister`.
 */
class StockRegisterSearch extends StockRegister {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['id', 'type', 'document_line_id', 'item_id', 'warehouse', 'shelf', 'weight_in', 'weight_out', 'balance_qty', 'status', 'CB', 'UB'], 'integer'],
                [['invoice_no', 'invoice_date', 'item_code', 'item_name', 'DOC', 'DOU'], 'safe'],
                [['item_cost'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = StockRegister::find()->orderBy(['id' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'document_line_id' => $this->document_line_id,
            'invoice_date' => $this->invoice_date,
            'item_id' => $this->item_id,
            'warehouse' => $this->warehouse,
            'shelf' => $this->shelf,
            'item_cost' => $this->item_cost,
            'weight_in' => $this->weight_in,
            'weight_out' => $this->weight_out,
            'balance_qty' => $this->balance_qty,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'invoice_no', $this->invoice_no])
                ->andFilterWhere(['like', 'item_code', $this->item_code])
                ->andFilterWhere(['like', 'item_name', $this->item_name]);

        return $dataProvider;
    }

}
