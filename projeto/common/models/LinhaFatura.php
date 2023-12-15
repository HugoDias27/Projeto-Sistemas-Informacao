<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linha_faturas".
 *
 * @property int $id
 * @property string $dta_venda
 * @property int $quantidade
 * @property float $precounit
 * @property float $valoriva
 * @property float $valorcomiva
 * @property float $subtotal
 * @property int $fatura_id
 * @property int|null $receita_medica_id
 * @property int|null $servico_id
 *
 * @property Fatura $fatura
 * @property ReceitaMedica $receitaMedica
 * @property Servico $servico
 */
class LinhaFatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linha_faturas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dta_venda', 'quantidade', 'precounit', 'valoriva', 'valorcomiva', 'subtotal', 'fatura_id'], 'required'],
            [['dta_venda'], 'safe'],
            [['quantidade', 'fatura_id', 'receita_medica_id', 'servico_id'], 'integer'],
            [['precounit', 'valoriva', 'valorcomiva', 'subtotal'], 'number'],
            [['fatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fatura::class, 'targetAttribute' => ['fatura_id' => 'id']],
            [['receita_medica_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReceitaMedica::class, 'targetAttribute' => ['receita_medica_id' => 'id']],
            [['servico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servico::class, 'targetAttribute' => ['servico_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dta_venda' => 'Dta Venda',
            'quantidade' => 'Quantidade',
            'precounit' => 'Precounit',
            'valoriva' => 'Valoriva',
            'valorcomiva' => 'Valorcomiva',
            'subtotal' => 'Subtotal',
            'fatura_id' => 'Fatura ID',
            'receita_medica_id' => 'Receita Medica ID',
            'servico_id' => 'Servico ID',
        ];
    }

    /**
     * Gets query for [[Fatura]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFatura()
    {
        return $this->hasOne(Fatura::class, ['id' => 'fatura_id']);
    }

    /**
     * Gets query for [[ReceitaMedica]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReceitaMedica()
    {
        return $this->hasOne(ReceitaMedica::class, ['id' => 'receita_medica_id']);
    }

    /**
     * Gets query for [[Servico]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServico()
    {
        return $this->hasOne(Servico::class, ['id' => 'servico_id']);
    }
}
