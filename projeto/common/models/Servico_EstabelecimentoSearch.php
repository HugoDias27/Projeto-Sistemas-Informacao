<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Servico_Estabelecimento;

/**
 * Servico_EstabelecimentoSearch represents the model behind the search form of `common\models\Servico_Estabelecimento`.
 */
class Servico_EstabelecimentoSearch extends Servico_Estabelecimento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estabelecimento_id', 'servico_id'], 'integer'],
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
        $query = Servico_Estabelecimento::find();

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
            'estabelecimento_id' => $this->estabelecimento_id,
            'servico_id' => $this->servico_id,
        ]);

        return $dataProvider;
    }
}
