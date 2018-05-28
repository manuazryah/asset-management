<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PurchaseDetails;

/**
 * PurchaseDetailsSearch represents the model behind the search form about `common\models\PurchaseDetails`.
 */
class PurchaseDetailsSearch extends PurchaseDetails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'master_id', 'material', 'qty', 'warehouse', 'shelf', 'status', 'CB', 'UB'], 'integer'],
            [['price', 'total'], 'number'],
            [['comment', 'DOC', 'DOU'], 'safe'],
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
        $query = PurchaseDetails::find();

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
            'master_id' => $this->master_id,
            'material' => $this->material,
            'qty' => $this->qty,
            'price' => $this->price,
            'total' => $this->total,
            'warehouse' => $this->warehouse,
            'shelf' => $this->shelf,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
