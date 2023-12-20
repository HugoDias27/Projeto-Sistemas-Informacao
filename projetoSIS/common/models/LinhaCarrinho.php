<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linhas_carrinho".
 *
 * @property int $id
 * @property int $quantidade
 * @property float $precounit
 * @property float $valoriva
 * @property float $valorcomiva
 * @property float $subtotal
 * @property int $carrinho_compra_id
 * @property int $produto_id
 *
 * @property CarrinhoCompra $carrinhoCompra
 * @property Produto $produto
 */
class LinhaCarrinho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhas_carrinho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade', 'precounit', 'valoriva', 'valorcomiva', 'subtotal', 'carrinho_compra_id', 'produto_id'], 'required'],
            [['quantidade', 'carrinho_compra_id', 'produto_id'], 'integer'],
            [['precounit', 'valoriva', 'valorcomiva', 'subtotal'], 'number'],
            [['carrinho_compra_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarrinhoCompra::class, 'targetAttribute' => ['carrinho_compra_id' => 'id']],
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
            'quantidade' => 'Quantidade',
            'precounit' => 'Precounit',
            'valoriva' => 'Valoriva',
            'valorcomiva' => 'Valorcomiva',
            'subtotal' => 'Subtotal',
            'carrinho_compra_id' => 'Carrinho Compra ID',
            'produto_id' => 'Produto ID',
        ];
    }

    /**
     * Gets query for [[CarrinhoCompra]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinhoCompra()
    {
        return $this->hasOne(CarrinhoCompra::class, ['id' => 'carrinho_compra_id']);
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
