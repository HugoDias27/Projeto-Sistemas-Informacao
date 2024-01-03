<?php

namespace common\models;

use common\mosquitto\phpMQTT;
use Yii;

/**
 * This is the model class for table "categorias".
 *
 * @property int $id
 * @property string $descricao
 *
 * @property Produto[] $produtos
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categorias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao'], 'required'],
            [['descricao'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descricao' => 'Descricao',
        ];
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['categoria_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $id = $this->id;
        $descricao = $this->descricao;
        $myObj = new \stdClass();
        $myObj->id = $id;
        $myObj->descricao = $descricao;
        $myJSON = json_encode($myObj);

        if ($insert) {
            $this->FazPublishMosquitto("INSERT_CATEGORIA", $myJSON);
        }
        else {
            $this->FazPublishMosquitto("UPDATE_CATEGORIA", $myJSON);
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        $id = $this->id;
        $myObj = new \stdClass();
        $myObj->id = $id;
        $myJSON = json_encode($myObj);

        $this->FazPublishMosquitto("DELETE_CATEGORIA", $myJSON);
    }

    public function FazPublishMosquitto($topic, $msg)
    {
        $server = "127.0.0.1";
        $port = 1883;
        $username = "";
        $password = "";
        $client_id = "phpMQTT-publisher";
        $mqtt = new phpMQTT($server, $port, $client_id);
        if($mqtt->connect(true, NULL, $username, $password)) {
            $mqtt->publish($topic, $msg, 0);
            $mqtt->close();
        } else {
            file_put_contents("debug.output", "Time out!");
        }
    }
}
