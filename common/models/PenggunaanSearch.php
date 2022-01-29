<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Penggunaan;

/**
 * PenggunaanSearch represents the model behind the search form of `common\models\Penggunaan`.
 */
class PenggunaanSearch extends Penggunaan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pelanggan_id', 'meter_awal', 'meter_akhir', 'petugas_id'], 'integer'],
            [['kode', 'bulan', 'tahun', 'tgl_cek'], 'safe'],
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
        $query = Penggunaan::find();

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
            'meter_awal' => $this->meter_awal,
            'meter_akhir' => $this->meter_akhir,
            'tgl_cek' => $this->tgl_cek,
            'petugas_id' => $this->petugas_id,
        ]);

        $query->andFilterWhere(['like', 'kode', $this->kode])
            ->andFilterWhere(['like', 'bulan', $this->bulan]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchTahun($params)
    {
        $query = Penggunaan::find();

        // add conditions that should always apply here
        $query->where(['>', 'meter_akhir', 0]);

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
            'meter_awal' => $this->meter_awal,
            'meter_akhir' => $this->meter_akhir,
            'tgl_cek' => $this->tgl_cek,
            'petugas_id' => $this->petugas_id,
        ]);

        $query->andFilterWhere(['like', 'kode', $this->kode])
            ->andFilterWhere(['like', 'bulan', $this->bulan]);

        return $dataProvider;
    }
}
