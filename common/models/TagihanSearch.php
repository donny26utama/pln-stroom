<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tagihan;

/**
 * TagihanSearch represents the model behind the search form of `common\models\Tagihan`.
 */
class TagihanSearch extends Tagihan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pelanggan_id', 'jumlah_meter', 'status', 'petugas_id'], 'integer'],
            [['uuid', 'bulan', 'tahun', 'data'], 'safe'],
            [['tarif_perkwh', 'total_bayar'], 'number'],
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
        $query = Tagihan::find();

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
            'pelanggan_id' => $this->pelanggan_id,
            'tahun' => $this->tahun,
            'jumlah_meter' => $this->jumlah_meter,
            'tarif_perkwh' => $this->tarif_perkwh,
            'total_bayar' => $this->total_bayar,
            'status' => $this->status,
            'petugas_id' => $this->petugas_id,
        ]);

        $query->andFilterWhere(['like', 'uuid', $this->uuid])
            ->andFilterWhere(['like', 'bulan', $this->bulan])
            ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }
}
