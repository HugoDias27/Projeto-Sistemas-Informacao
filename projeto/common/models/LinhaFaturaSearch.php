<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LinhaFatura;

/**
 * LinhaFaturaSearch represents the model behind the search form of `common\models\LinhaFatura`.
 */
class LinhaFaturaSearch extends LinhaFatura
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'quantidade', 'fatura_id', 'receita_medica_id', 'servico_id'], 'integer'],
            [['dta_venda'], 'safe'],
            [['precounit', 'valoriva', 'valorcomiva', 'subtotal'], 'number'],
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
        $query = LinhaFatura::find();

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
            'dta_venda' => $this->dta_venda,
            'quantidade' => $this->quantidade,
            'precounit' => $this->precounit,
            'valoriva' => $this->valoriva,
            'valorcomiva' => $this->valorcomiva,
            'subtotal' => $this->subtotal,
            'fatura_id' => $this->fatura_id,
            'receita_medica_id' => $this->receita_medica_id,
            'servico_id' => $this->servico_id,
        ]);

        return $dataProvider;
    }
}
