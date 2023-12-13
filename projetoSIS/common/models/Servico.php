<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "servicos".
 *
 * @property int $id
 * @property string $nome
 * @property string $duracao
 * @property float $preco
 * @property int $iva_id
 *
 * @property Estabelecimento[] $estabelecimentos
 * @property Iva $iva
 * @property LinhaFatura[] $linhaFaturas
 * @property ServicoEstabelecimento[] $servicosEstabelecimentos
 */
class Servico extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servicos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'duracao', 'preco', 'iva_id'], 'required'],
            [['duracao'], 'safe'],
            [['preco'], 'number'],
            [['iva_id'], 'integer'],
            [['nome'], 'string', 'max' => 45],
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
            'duracao' => 'Duracao',
            'preco' => 'Preco',
            'iva_id' => 'Iva ID',
        ];
    }

    /**
     * Gets query for [[Estabelecimentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstabelecimentos()
    {
        return $this->hasMany(Estabelecimento::class, ['id' => 'estabelecimento_id'])->viaTable('servicos_estabelecimentos', ['servico_id' => 'id']);
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
     * Gets query for [[LinhaFaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhaFaturas()
    {
        return $this->hasMany(LinhaFatura::class, ['servico_id' => 'id']);
    }

    /**
     * Gets query for [[ServicosEstabelecimentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServicosEstabelecimentos()
    {
        return $this->hasMany(ServicoEstabelecimento::class, ['servico_id' => 'id']);
    }
}
