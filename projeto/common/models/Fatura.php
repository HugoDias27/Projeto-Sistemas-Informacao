<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "faturas".
 *
 * @property int $id
 * @property string $dta_emissao
 * @property string $loja
 * @property string $emissor
 * @property float $total_fatura
 * @property int $cliente_id
 * @property int|null $receita_id
 *
 * @property Profile $cliente
 * @property LinhaFatura[] $linhaFaturas
 * @property ReceitasMedica $receita
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
            [['dta_emissao', 'loja', 'emissor', 'total_fatura', 'cliente_id'], 'required'],
            [['dta_emissao'], 'safe'],
            [['total_fatura'], 'number'],
            [['cliente_id', 'receita_id'], 'integer'],
            [['loja'], 'string', 'max' => 20],
            [['emissor'], 'string', 'max' => 25],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['cliente_id' => 'id']],
            [['receita_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReceitasMedica::class, 'targetAttribute' => ['receita_id' => 'id']],
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
            'loja' => 'Loja',
            'emissor' => 'Emissor',
            'total_fatura' => 'Total Fatura',
            'cliente_id' => 'Cliente ID',
            'receita_id' => 'Receita ID',
        ];
    }

    /**
     * Gets query for [[Cliente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Profile::class, ['id' => 'cliente_id']);
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

    /**
     * Gets query for [[Receita]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReceita()
    {
        return $this->hasOne(ReceitasMedica::class, ['id' => 'receita_id']);
    }
}
