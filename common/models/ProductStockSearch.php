<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductStockView;

/**
 * ProductStockViewSearch represents the model behind the search form about `common\models\ProductStockView`.
 */
class ProductStockSearch extends ProductStockView {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'available_qty', 'unit', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU', 'product_id'], 'safe'],
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
        $query = ProductStockView::find()->orderBy(['id' => SORT_DESC]);

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

        if ($this->product_id != '') {
            $arr_data = [];
            $products = FinishedProduct::find()->where(['like', 'product_name', $this->product_id])->all();
            foreach ($products as $product) {
                $arr_data[] = $product->id;
            }
            $query->andWhere(['product_id' => $arr_data]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
//            'product_id' => $this->product_id,
            'available_qty' => $this->available_qty,
            'unit' => $this->unit,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        return $dataProvider;
    }

}
