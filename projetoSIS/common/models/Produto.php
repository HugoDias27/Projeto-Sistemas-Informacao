<?php

namespace common\models;

use common\models\Fornecedor;
use common\models\FornecedorProduto;
use Yii;

/**
 * This is the model class for table "produtos".
 *
 * @property int $id
 * @property string $nome
 * @property int $prescricao_medica
 * @property float $preco
 * @property int $quantidade
 * @property int|null $categoria_id
 * @property int $iva_id
 *
 * @property Categoria $categoria
 * @property FornecedorProduto[] $fornecedoresProdutos
 * @property Fornecedor[] $fornecedors
 * @property Imagem[] $imagens
 * @property Iva $iva
 * @property LinhaCarrinho[] $linhasCarrinhos
 */
class Produto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produtos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'prescricao_medica', 'preco', 'quantidade', 'iva_id'], 'required'],
            [['prescricao_medica', 'quantidade', 'categoria_id', 'iva_id'], 'integer'],
            [['preco'], 'number'],
            [['nome'], 'string', 'max' => 45],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
            [['iva_id'], 'exist', 'skipOnError' => true, 'targetClass' => Iva::class, 'targetAttribute' => ['iva_id' => 'id']],
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
            'prescricao_medica' => 'Prescricao Medica',
            'preco' => 'Preco',
            'quantidade' => 'Quantidade',
            'categoria_id' => 'Categoria ID',
            'iva_id' => 'Iva ID',
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }

    /**
     * Gets query for [[FornecedoresProdutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedoresProdutos()
    {
        return $this->hasMany(FornecedorProduto::class, ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[Fornecedors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedores()
    {
        return $this->hasMany(Fornecedor::class, ['id' => 'fornecedor_id'])->viaTable('fornecedores_produtos', ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[Imagens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagens()
    {
        return $this->hasMany(Imagem::class, ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[Iva]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIva()
    {
        return $this->hasOne(Iva::class, ['id' => 'iva_id']);
    }

    /**
     * Gets query for [[LinhasCarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasCarrinhos()
    {
        return $this->hasMany(LinhaCarrinho::class, ['produto_id' => 'id']);
    }


}