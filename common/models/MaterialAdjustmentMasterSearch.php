<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MaterialAdjustmentMaster;

/**
 * MaterialAdjustmentMasterSearch represents the model behind the search form about `common\models\MaterialAdjustmentMaster`.
 */
class MaterialAdjustmentMasterSearch extends MaterialAdjustmentMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'transaction', 'status', 'CB', 'UB', 'DOC'], 'integer'],
            [['document_no', 'document_date', 'DOU'], 'safe'],
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
        $query = MaterialAdjustmentMaster::find();

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
            'transaction' => $this->transaction,
            'document_date' => $this->document_date,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'document_no', $this->document_no]);

        return $dataProvider;
    }
}
