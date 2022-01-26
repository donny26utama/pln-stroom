<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Pelanggan;

/**
 * PelangganSearch represents the model behind the search form of `common\models\Pelanggan`.
 */
class PelangganSearch extends Pelanggan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tarif_id', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['uuid', 'kode', 'no_meter', 'nama', 'alamat', 'tenggang'], 'safe'],
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
        $query = Pelanggan::find();

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
            'tarif_id' => $this->tarif_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'uuid', $this->uuid])
            ->andFilterWhere(['like', 'kode', $this->kode])
            ->andFilterWhere(['like', 'no_meter', $this->no_meter])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'tenggang', $this->tenggang]);

        return $dataProvider;
    }
}
