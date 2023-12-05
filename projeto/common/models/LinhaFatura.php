<?php

namespace common\models;

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
 *
 * @property Fatura $fatura
 * @property Produto $produto
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
            [['dta_venda', 'quantidade', 'preco', 'fatura_id', 'produto_id'], 'required'],
            [['dta_venda'], 'safe'],
            [['quantidade', 'fatura_id', 'produto_id'], 'integer'],
            [['preco'], 'number'],
            [['fatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fatura::class, 'targetAttribute' => ['fatura_id' => 'id']],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
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
}
