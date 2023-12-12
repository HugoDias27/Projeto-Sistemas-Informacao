<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fornecedores".
 *
 * @property int $id
 * @property string $nome
 * @property int $telefone
 * @property string $email
 *
 * @property FornecedorProduto[] $fornecedoresProdutos
 * @property Produto[] $produtos
 */
class Fornecedor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fornecedores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'telefone', 'email'], 'required'],
            [['telefone'], 'integer'],
            [['nome', 'email'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'telefone' => 'Telefone',
            'email' => 'Email',
        ];
    }

    /**
     * Gets query for [[FornecedoresProdutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedoresProdutos()
    {
        return $this->hasMany(FornecedorProduto::class, ['fornecedor_id' => 'id']);
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['id' => 'produto_id'])->viaTable('fornecedores_produtos', ['fornecedor_id' => 'id']);
    }
}
