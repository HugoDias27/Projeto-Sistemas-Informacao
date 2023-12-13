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
 * @property string $posologia
 * @property int $user_id
 *
 * @property LinhaFatura[] $linhaFaturas
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
            [['codigo', 'local_prescricao', 'medico_prescricao', 'dosagem', 'data_validade', 'telefone', 'valido', 'posologia', 'user_id'], 'required'],
            [['codigo', 'dosagem', 'telefone', 'valido', 'user_id'], 'integer'],
            [['data_validade'], 'safe'],
            [['local_prescricao', 'medico_prescricao'], 'string', 'max' => 45],
            [['posologia'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['user_id' => 'user_id']],
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
            'posologia' => 'Posologia',
            'user_id' => 'User ID',
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'user_id']);
    }
}
