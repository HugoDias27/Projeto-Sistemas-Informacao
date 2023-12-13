<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "servicos_estabelecimentos".
 *
 * @property int $estabelecimento_id
 * @property int $servico_id
 *
 * @property Estabelecimento $estabelecimento
 * @property Servico $servico
 */
class ServicoEstabelecimento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servicos_estabelecimentos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estabelecimento_id', 'servico_id'], 'required'],
            [['estabelecimento_id', 'servico_id'], 'integer'],
            [['estabelecimento_id', 'servico_id'], 'unique', 'targetAttribute' => ['estabelecimento_id', 'servico_id']],
            [['estabelecimento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estabelecimento::class, 'targetAttribute' => ['estabelecimento_id' => 'id']],
            [['servico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servico::class, 'targetAttribute' => ['servico_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'estabelecimento_id' => 'Estabelecimento ID',
            'servico_id' => 'Servico ID',
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

    /**
     * Gets query for [[Servico]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServico()
    {
        return $this->hasOne(Servico::class, ['id' => 'servico_id']);
    }
}
