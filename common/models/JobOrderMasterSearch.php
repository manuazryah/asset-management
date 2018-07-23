<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\JobOrderMaster;

/**
 * JobOrderMasterSearch represents the model behind the search form about `common\models\JobOrderMaster`.
 */
class JobOrderMasterSearch extends JobOrderMaster
{
    public $created_at_range;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'CB', 'UB'], 'integer'],
            [['bom_no', 'bom_date', 'comment', 'DOC', 'DOU'], 'safe'],
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
        $query = JobOrderMaster::find();

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
        if (!empty($this->bom_date) && strpos($this->bom_date, '-') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->bom_date);
            $query->andFilterWhere(['between', 'date(bom_date)', $start_date, $end_date]);
            $this->bom_date = "";
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'bom_date' => $this->bom_date,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'bom_no', $this->bom_no])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
