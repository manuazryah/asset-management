<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StockView;

/**
 * StockViewSearch represents the model behind the search form about `common\models\StockView`.
 */
class StockViewSearch extends StockView {
    
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'material_id', 'available_qty', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU', 'material_category'], 'safe'],
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
        $query = StockView::find()->orderBy(['id' => SORT_DESC]);
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
        if ($this->material_category != '') {
            $arr_data = [];
            $materials = SupplierwiseRowMaterial::find()->where(['material_ctegory' => $this->material_category])->all();
            foreach ($materials as $material) {
                $arr_data[] = $material->id;
            }
            $query->andWhere(['material_id' => $arr_data]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'material_id' => $this->material_id,
            'available_qty' => $this->available_qty,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        return $dataProvider;
    }

}
