<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ReceitaMedica;

/**
 * ReceitaMedicaSearch represents the model behind the search form of `common\models\ReceitaMedica`.
 */
class ReceitaMedicaSearch extends ReceitaMedica
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'codigo', 'dosagem', 'telefone', 'valido', 'user_id', 'posologia'], 'integer'],
            [['local_prescricao', 'medico_prescricao', 'data_validade'], 'safe'],
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
        $query = ReceitaMedica::find();

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
            'codigo' => $this->codigo,
            'dosagem' => $this->dosagem,
            'data_validade' => $this->data_validade,
            'telefone' => $this->telefone,
            'valido' => $this->valido,
            'user_id' => $this->user_id,
            'posologia' => $this->posologia,
        ]);

        $query->andFilterWhere(['like', 'local_prescricao', $this->local_prescricao])
            ->andFilterWhere(['like', 'medico_prescricao', $this->medico_prescricao]);

        return $dataProvider;
    }
}
