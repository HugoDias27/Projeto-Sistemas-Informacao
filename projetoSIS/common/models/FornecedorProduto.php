<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fornecedores_produtos".
 *
 * @property int $produto_id
 * @property int $fornecedor_id
 * @property string $data_importacao
 * @property int $quantidade
 * @property string $hora_importacao
 *
 * @property Fornecedor $fornecedor
 * @property Produto $produto
 */
class FornecedorProduto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fornecedores_produtos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produto_id', 'fornecedor_id', 'data_importacao', 'quantidade', 'hora_importacao'], 'required'],
            [['produto_id', 'fornecedor_id', 'quantidade'], 'integer'],
            [['data_importacao', 'hora_importacao'], 'safe'],
            [['produto_id', 'fornecedor_id'], 'unique', 'targetAttribute' => ['produto_id', 'fornecedor_id']],
            [['fornecedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fornecedor::class, 'targetAttribute' => ['fornecedor_id' => 'id']],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'produto_id' => 'Produto ID',
            'fornecedor_id' => 'Fornecedor ID',
            'data_importacao' => 'Data Importacao',
            'quantidade' => 'Quantidade',
            'hora_importacao' => 'Hora Importacao',
        ];
    }

    /**
     * Gets query for [[Fornecedor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedor()
    {
        return $this->hasOne(Fornecedor::class, ['id' => 'fornecedor_id']);
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
