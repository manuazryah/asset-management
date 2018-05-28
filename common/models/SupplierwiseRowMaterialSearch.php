<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SupplierwiseRowMaterial;

/**
 * SupplierwiseRowMaterialSearch represents the model behind the search form about `common\models\SupplierwiseRowMaterial`.
 */
class SupplierwiseRowMaterialSearch extends SupplierwiseRowMaterial
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'master_row_material_id', 'supplier', 'status', 'CB', 'UB', 'item_unit'], 'integer'],
            [['item_code', 'item_name', 'photo', 'reference', 'minimum_quantity', 'comment', 'DOC', 'DOU'], 'safe'],
            [['purchase_price'], 'number'],
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
        $query = SupplierwiseRowMaterial::find()->orderBy(['id'=>SORT_DESC]);

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
            'master_row_material_id' => $this->master_row_material_id,
            'supplier' => $this->supplier,
            'purchase_price' => $this->purchase_price,
            'item_unit' => $this->item_unit,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'item_code', $this->item_code])
            ->andFilterWhere(['like', 'item_name', $this->item_name])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'reference', $this->reference])
            ->andFilterWhere(['like', 'minimum_quantity', $this->minimum_quantity])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
