<?php

namespace common\models;

use backend\models\Servico;
use Yii;

/**
 * This is the model class for table "linha_faturas".
 *
 * @property int $id
 * @property string $dta_venda
 * @property int $quantidade
 * @property float $preco
 * @property int $fatura_id
 * @property int $produto_id
 * @property int|null $receita_medica_id
 * @property int $servico_id
 *
 * @property Fatura $fatura
 * @property Produto $produto
 * @property ReceitaMedica $receitasMedica
 * @property Servico $servicos
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
            [['dta_venda', 'quantidade', 'preco', 'fatura_id', 'produto_id', 'servicos_id'], 'required'],
            [['dta_venda'], 'safe'],
            [['quantidade', 'fatura_id', 'produto_id', 'receita_medica_id', 'servicos_id'], 'integer'],
            [['preco'], 'number'],
            [['fatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fatura::class, 'targetAttribute' => ['fatura_id' => 'id']],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
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
            'preco' => 'Preco',
            'fatura_id' => 'Fatura ID',
            'produto_id' => 'Produto ID',
            'receitas_medica_id' => 'Receitas Medica ID',
            'servicos_id' => 'Servicos ID',
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
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['id' => 'produto_id']);
    }

    /**
     * Gets query for [[ReceitasMedica]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReceitasMedica()
    {
        return $this->hasOne(ReceitaMedica::class, ['id' => 'receitas_medica_id']);
    }

    /**
     * Gets query for [[Servicos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServicos()
    {
        return $this->hasOne(Servico::class, ['id' => 'servico_id']);
    }
}
