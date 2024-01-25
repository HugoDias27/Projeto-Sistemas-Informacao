<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CarrinhoCompra;

/**
 * CarrinhoCompraSearch represents the model behind the search form of `common\models\CarrinhoCompra`.
 */
class CarrinhoCompraSearch extends CarrinhoCompra
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'quantidade', 'cliente_id', 'fatura_id'], 'integer'],
            [['dta_venda'], 'safe'],
            [['valortotal', 'ivatotal'], 'number'],
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
        $query = CarrinhoCompra::find();

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
            'valortotal' => $this->valortotal,
            'ivatotal' => $this->ivatotal,
            'cliente_id' => $this->cliente_id,
            'fatura_id' => $this->fatura_id,
        ]);

        return $dataProvider;
    }
}
