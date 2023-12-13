<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "faturas".
 *
 * @property int $id
 * @property string $dta_emissao
 * @property float $valortotal
 * @property float $ivatotal
 * @property int $cliente_id
 * @property int|null $estabelecimento_id
 * @property int|null $emissor_id
 *
 * @property CarrinhoCompra[] $carrinhoCompras
 * @property Profile $cliente
 * @property Profile $emissor
 * @property Estabelecimento $estabelecimento
 * @property LinhaFatura[] $linhaFaturas
 */
class Fatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faturas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dta_emissao', 'valortotal', 'ivatotal', 'cliente_id'], 'required'],
            [['dta_emissao'], 'safe'],
            [['valortotal', 'ivatotal'], 'number'],
            [['cliente_id', 'estabelecimento_id', 'emissor_id'], 'integer'],
            [['estabelecimento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estabelecimento::class, 'targetAttribute' => ['estabelecimento_id' => 'id']],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['cliente_id' => 'user_id']],
            [['emissor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['emissor_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dta_emissao' => 'Dta Emissao',
            'valortotal' => 'Valortotal',
            'ivatotal' => 'Ivatotal',
            'cliente_id' => 'Cliente ID',
            'estabelecimento_id' => 'Estabelecimento ID',
            'emissor_id' => 'Emissor ID',
        ];
    }

    /**
     * Gets query for [[CarrinhoCompras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinhoCompras()
    {
        return $this->hasMany(CarrinhoCompra::class, ['fatura_id' => 'id']);
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
     * Gets query for [[Emissor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmissor()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'emissor_id']);
    }

    /**
     * Gets query for [[Estabelecimento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstabelecimento()
    {
        return $this->hasOne(Estabelecimento::class, ['id' => 'estabelecimento_id']);
    }

    /**
     * Gets query for [[LinhaFaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhaFaturas()
    {
        return $this->hasMany(LinhaFatura::class, ['fatura_id' => 'id']);
    }
}
