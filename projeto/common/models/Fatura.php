<?php

namespace common\models;

use backend\models\Estabelecimento;
use Yii;

/**
 * This is the model class for table "faturas".
 *
 * @property int $id
 * @property string $dta_emissao
 * @property float $total_fatura
 * @property int $cliente_id
 * @property int|null $estabelecimento_id
 * @property int $emissor_id
 *
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
            [['dta_emissao', 'total_fatura', 'cliente_id', 'emissor_id'], 'required'],
            [['dta_emissao'], 'safe'],
            [['total_fatura'], 'number'],
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
            'total_fatura' => 'Total Fatura',
            'cliente_id' => 'Cliente ID',
            'estabelecimento_id' => 'Estabelecimento ID',
            'emissor_id' => 'Emissor ID',
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
