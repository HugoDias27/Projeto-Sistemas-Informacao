<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "despesas".
 *
 * @property int $id
 * @property float $preco
 * @property string $dta_despesa
 * @property string|null $descricao
 * @property int $estabelecimento_id
 *
 * @property Estabelecimentos $estabelecimento
 */
class Despesa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'despesas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['preco', 'dta_despesa', 'estabelecimento_id'], 'required'],
            [['preco'], 'number'],
            [['dta_despesa'], 'safe'],
            [['estabelecimento_id'], 'integer'],
            [['descricao'], 'string', 'max' => 60],
            [['estabelecimento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estabelecimento::class, 'targetAttribute' => ['estabelecimento_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preco' => 'Preco',
            'dta_despesa' => 'Dta Despesa',
            'descricao' => 'Descricao',
            'estabelecimento_id' => 'Estabelecimento ID',
        ];
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
}
