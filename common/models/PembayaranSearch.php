<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Pembayaran;

/**
 * PembayaranSearch represents the model behind the search form of `common\models\Pembayaran`.
 */
class PembayaranSearch extends Pembayaran
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'agen_id'], 'integer'],
            [['uuid', 'tgl_bayar'], 'safe'],
            [['jumlah_tagihan', 'biaya_admin', 'total_bayar', 'bayar', 'kembalian'], 'number'],
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
        $query = Pembayaran::find();

        // add conditions that should always apply here
        $query->orderBy(['tgl_bayar' => SORT_ASC]);

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
            'tgl_bayar' => $this->tgl_bayar,
            'jumlah_tagihan' => $this->jumlah_tagihan,
            'biaya_admin' => $this->biaya_admin,
            'total_bayar' => $this->total_bayar,
            'bayar' => $this->bayar,
            'kembalian' => $this->kembalian,
            'agen_id' => $this->agen_id,
        ]);

        $query->andFilterWhere(['like', 'uuid', $this->uuid]);

        return $dataProvider;
    }
}
