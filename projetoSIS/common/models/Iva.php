<?php

namespace common\models;

use common\mosquitto\phpMQTT;
use Yii;

/**
 * This is the model class for table "ivas".
 *
 * @property int $id
 * @property int $percentagem
 * @property int $vigor
 * @property string|null $descricao
 *
 * @property Produto[] $produtos
 * @property Servico[] $servicos
 */
class Iva extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ivas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['percentagem', 'vigor'], 'required'],
            [['percentagem', 'vigor'], 'integer'],
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
            'percentagem' => 'Percentagem',
            'vigor' => 'Vigor',
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
        return $this->hasMany(Produto::class, ['iva_id' => 'id']);
    }

    /**
     * Gets query for [[Servicos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServicos()
    {
        return $this->hasMany(Servico::class, ['iva_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $id = $this->id;
        $percentagem = $this->percentagem;
        $vigor = $this->vigor;
        $descricao = $this->descricao;

        $myObj = new \stdClass();
        $myObj->id = $id;
        $myObj->percentagem = $percentagem;
        $myObj->vigor = $vigor;
        $myObj->descricao = $descricao;

        if ($insert) {
            $myJSON = "Foi inserido um novo iva!" . json_encode($myObj->descricao);
            $this->FazPublishMosquitto("INSERT_IVA", $myJSON);
        }
        else {
            $myJSON = "Foi atualizado um iva!" . json_encode($myObj->descricao);
            $this->FazPublishMosquitto("UPDATE_IVA", $myJSON);
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        $id = $this->id;

        $myObj = new \stdClass();
        $myObj->id = $id;
        $myJSON = "Foi apagado um iva!";

        $this->FazPublishMosquitto("DELETE_IVA", $myJSON);
    }

    public function FazPublishMosquitto($canal, $msg)
    {
        $server = "127.0.0.1";
        $port = 1883;
        $username = "";
        $password = "";
        $client_id = "phpMQTT-publisher";
        $mqtt = new phpMQTT($server, $port, $client_id);
        if($mqtt->connect(true, NULL, $username, $password)) {
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        } else {
            file_put_contents("debug.output", "Time out!");
        }

    }
}
