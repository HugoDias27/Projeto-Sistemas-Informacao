<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "receitas_medica".
 *
 * @property int $id
 * @property string $nome
 * @property int $codigo
 * @property string $local_prescricao
 * @property string $medico_prescricao
 * @property int $dosagem
 * @property string $data_validade
 * @property int $telefone
 * @property int $valido
 * @property string $posologia
 *
 * @property Fatura[] $faturas
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
            [['nome', 'codigo', 'local_prescricao', 'medico_prescricao', 'dosagem', 'data_validade', 'telefone', 'valido', 'posologia'], 'required'],
            [['codigo', 'dosagem', 'telefone', 'valido'], 'integer'],
            [['data_validade'], 'safe'],
            [['nome', 'local_prescricao', 'medico_prescricao'], 'string', 'max' => 45],
            [['posologia'], 'string', 'max' => 50],
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
            'codigo' => 'Codigo',
            'local_prescricao' => 'Local Prescricao',
            'medico_prescricao' => 'Medico Prescricao',
            'dosagem' => 'Dosagem',
            'data_validade' => 'Data Validade',
            'telefone' => 'Telefone',
            'valido' => 'Valido',
            'posologia' => 'Posologia',
        ];
    }

    /**
     * Gets query for [[Faturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturas()
    {
        return $this->hasMany(Fatura::class, ['receita_id' => 'id']);
    }
}
