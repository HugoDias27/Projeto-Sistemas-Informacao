<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "receitas_medica".
 *
 * @property int $id
 * @property int $codigo
 * @property string $local_prescricao
 * @property string $medico_prescricao
 * @property int $dosagem
 * @property string $data_validade
 * @property int $telefone
 * @property int $valido
 * @property int $user_id
 * @property int $posologia
 *
 * @property LinhaFatura[] $linhaFaturas
 * @property Produto $posologiaProduto
 * @property Profile $user
 */
class ReceitaMedica extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receitas_medica';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo', 'local_prescricao', 'medico_prescricao', 'dosagem', 'data_validade', 'telefone', 'valido', 'user_id', 'posologia'], 'required'],
            [['codigo', 'dosagem', 'telefone', 'valido', 'user_id', 'posologia'], 'integer'],
            [['data_validade'], 'safe'],
            [['local_prescricao', 'medico_prescricao'], 'string', 'max' => 45],
            [['posologia'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['posologia' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['user_id' => 'user_id'], 'message' => 'O utilizador não tem o perfil criado.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'local_prescricao' => 'Local Prescricao',
            'medico_prescricao' => 'Medico Prescricao',
            'dosagem' => 'Dosagem',
            'data_validade' => 'Data Validade',
            'telefone' => 'Telefone',
            'valido' => 'Valido',
            'user_id' => 'User ID',
            'posologia' => 'Posologia',
        ];
    }

    /**
     * Gets query for [[LinhaFaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhaFaturas()
    {
        return $this->hasMany(LinhaFatura::class, ['receita_medica_id' => 'id']);
    }

    /**
     * Gets query for [[Posologia0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosologiaProduto()
    {
        return $this->hasOne(Produto::class, ['id' => 'posologia']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
