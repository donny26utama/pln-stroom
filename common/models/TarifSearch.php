<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tarif;

/**
 * TarifSearch represents the model behind the search form of `common\models\Tarif`.
 */
class TarifSearch extends Tarif
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['uuid', 'kode', 'golongan', 'daya'], 'safe'],
            [['tarif_perkwh'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Tarif::find();

        // add conditions that should always apply here
        $query->where(['deleted_at' => null]);

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
            'tarif_perkwh' => $this->tarif_perkwh,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'uuid', $this->uuid])
            ->andFilterWhere(['like', 'kode', $this->kode])
            ->andFilterWhere(['like', 'golongan', $this->golongan])
            ->andFilterWhere(['like', 'daya', $this->daya]);

        return $dataProvider;
    }
}
