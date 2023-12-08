<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property int $id
 * @property int|null $n_utente
 * @property int $nif
 * @property string $morada
 * @property int $telefone
 * @property int $user_id
 *
 * @property CarrinhoCompra[] $carrinhoCompras
 * @property Fatura[] $faturas
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['n_utente', 'nif', 'telefone', 'user_id'], 'integer'],
            [['nif', 'morada', 'telefone', 'user_id'], 'required'],
            [['morada'], 'string', 'max' => 30],
            [['nif', 'telefone', 'n_utente'], 'double', 'max' => 1000000000],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'n_utente' => 'Número de Utente',
            'nif' => 'Nif',
            'morada' => 'Morada',
            'telefone' => 'Telefone',
            'user_id' => 'Utilizador',
        ];
    }

    /**
     * Gets query for [[CarrinhoCompras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinhoCompras()
    {
        return $this->hasMany(CarrinhoCompra::class, ['cliente_id' => 'id']);
    }

    /**
     * Gets query for [[Faturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturas()
    {
        return $this->hasMany(Fatura::class, ['cliente_id' => 'id']);
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
