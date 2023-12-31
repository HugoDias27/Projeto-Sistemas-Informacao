<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carrinho_compras".
 *
 * @property int $id
 * @property string|null $dta_venda
 * @property int|null $quantidade
 * @property float|null $valortotal
 * @property float|null $ivatotal
 * @property int $cliente_id
 * @property int|null $fatura_id
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
            [['dta_venda'], 'safe'],
            [['quantidade', 'cliente_id', 'fatura_id'], 'integer'],
            [['valortotal', 'ivatotal'], 'number'],
            [['cliente_id'], 'required'],
            [['fatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fatura::class, 'targetAttribute' => ['fatura_id' => 'id']],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['cliente_id' => 'id']],
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
        return $this->hasOne(User::class, ['id' => 'cliente_id']);
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
