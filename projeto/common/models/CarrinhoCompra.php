<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carrinho_compras".
 *
 * @property int $id
 * @property string $dta_venda
 * @property int $quantidade
 * @property float $valortotal
 * @property float $ivatotal
 * @property int $cliente_id
 * @property int $fatura_id
 *
 * @property Profile $cliente
 * @property Fatura $fatura
 * @property LinhaCarrinho[] $linhasCarrinhos
 */
class CarrinhoCompra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrinho_compras';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dta_venda', 'quantidade', 'valortotal', 'ivatotal', 'cliente_id', 'fatura_id'], 'required'],
            [['dta_venda'], 'safe'],
            [['quantidade', 'cliente_id', 'fatura_id'], 'integer'],
            [['valortotal', 'ivatotal'], 'number'],
            [['fatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fatura::class, 'targetAttribute' => ['fatura_id' => 'id']],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['cliente_id' => 'user_id']],
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
            'valortotal' => 'Valortotal',
            'ivatotal' => 'Ivatotal',
            'cliente_id' => 'Cliente ID',
            'fatura_id' => 'Fatura ID',
        ];
    }

    /**
     * Gets query for [[Cliente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'cliente_id']);
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
     * Gets query for [[LinhasCarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasCarrinhos()
    {
        return $this->hasMany(LinhaCarrinho::class, ['carrinho_compra_id' => 'id']);
    }
}
