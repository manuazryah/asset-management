<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FinishedProduct;

/**
 * FinishedProductSearch represents the model behind the search form about `common\models\FinishedProduct`.
 */
class FinishedProductSearch extends FinishedProduct
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_category', 'fragrance_type', 'brand', 'size', 'unit', 'gender', 'status', 'CB', 'UB'], 'integer'],
            [['product_name', 'product_code', 'item_photo', 'reference', 'comment', 'DOC', 'DOU'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = FinishedProduct::find()->orderBy(['id'=>SORT_DESC]);

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
            'product_category' => $this->product_category,
            'fragrance_type' => $this->fragrance_type,
            'price' => $this->price,
            'brand' => $this->brand,
            'size' => $this->size,
            'unit' => $this->unit,
            'gender' => $this->gender,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_code', $this->product_code])
            ->andFilterWhere(['like', 'item_photo', $this->item_photo])
            ->andFilterWhere(['like', 'reference', $this->reference])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
