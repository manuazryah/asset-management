<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BomDetails;

/**
 * BomDetailsSearch represents the model behind the search form about `common\models\BomDetails`.
 */
class BomDetailsSearch extends BomDetails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'finished_product_id', 'master_row_material_id', 'row_material_id', 'quantity', 'status', 'CB', 'UB'], 'integer'],
            [['unit', 'comment', 'DOC', 'DOU'], 'safe'],
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
        $query = BomDetails::find();

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
            'finished_product_id' => $this->finished_product_id,
            'master_row_material_id' => $this->master_row_material_id,
            'row_material_id' => $this->row_material_id,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
