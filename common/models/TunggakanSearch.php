<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tunggakan;

/**
 * TunggakanSearch represents the model behind the search form of `common\models\Tunggakan`.
 */
class TunggakanSearch extends Tunggakan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pelanggan_id', 'tunggakan'], 'integer'],
            [['bulan'], 'safe'],
            [['jumlah_meter', 'total_bayar', 'tarif_perkwh'], 'number'],
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
        $query = Tunggakan::find();

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
            'pelanggan_id' => $this->pelanggan_id,
            'tunggakan' => $this->tunggakan,
            'jumlah_meter' => $this->jumlah_meter,
            'total_bayar' => $this->total_bayar,
            'tarif_perkwh' => $this->tarif_perkwh,
        ]);

        $query->andFilterWhere(['like', 'bulan', $this->bulan]);

        return $dataProvider;
    }
}
