<?php

namespace common\models;


use common\mosquitto\phpMQTT;
use common\models\Fornecedor;
use common\models\FornecedorProduto;
use Exception;
use Yii;

/**
 * This is the model class for table "produtos".
 *
 * @property int $id
 * @property string $nome
 * @property int $prescricao_medica
 * @property float $preco
 * @property int $quantidade
 * @property int|null $categoria_id
 * @property int $iva_id
 *
 * @property Categoria $categoria
 * @property FornecedorProduto[] $fornecedoresProdutos
 * @property Fornecedor[] $fornecedors
 * @property Imagem[] $imagens
 * @property Iva $iva
 * @property LinhaCarrinho[] $linhasCarrinhos
 */
class Produto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produtos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'prescricao_medica', 'preco', 'quantidade', 'iva_id'], 'required'],
            [['prescricao_medica', 'quantidade', 'categoria_id', 'iva_id'], 'integer'],
            [['preco'], 'number'],
            [['nome'], 'string', 'max' => 45],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
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
            'prescricao_medica' => 'Prescricao Medica',
            'preco' => 'Preco',
            'quantidade' => 'Quantidade',
            'categoria_id' => 'Categoria ID',
            'iva_id' => 'Iva ID',
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }

    /**
     * Gets query for [[FornecedoresProdutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedoresProdutos()
    {
        return $this->hasMany(FornecedorProduto::class, ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[Fornecedors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedores()
    {
        return $this->hasMany(Fornecedor::class, ['id' => 'fornecedor_id'])->viaTable('fornecedores_produtos', ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[Imagens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagens()
    {
        return $this->hasMany(Imagem::class, ['produto_id' => 'id']);
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
     * Gets query for [[LinhasCarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasCarrinhos()
    {
        return $this->hasMany(LinhaCarrinho::class, ['produto_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $id = $this->id;
        $nome = $this->nome;
        $prescricaoMedica = $this->prescricao_medica;
        $preco = $this->preco;
        $quantidade = $this->quantidade;
        $categoria = $this->categoria_id;
        $iva = $this->iva_id;

        $myObj = new \stdClass();
        $myObj->id = $id;
        $myObj->nome = $nome;
        $myObj->prescricao_medica = $prescricaoMedica;
        $myObj->preco = $preco;
        $myObj->quantidade = $quantidade;
        $myObj->categoria_id = $categoria;
        $myObj->iva_id = $iva;

        $myJSON = json_encode($myObj);

        if ($insert) {
            $this->FazPublishMosquitto("INSERT_PRODUTO", $myJSON);
        }
        else {
            $this->FazPublishMosquitto("UPDATE_PRODUTO", $myJSON);
        }

    }

    public function afterDelete()
    {
        parent::afterDelete();

        $prod_id = $this->id;
        $myObj = new \stdClass();
        $myObj->id = $prod_id;
        $myJSON = json_encode($myObj);

        $this->FazPublishMosquitto("DELETE_PRODUTO", $myJSON);
    }

    public function FazPublishMosquitto($canal, $msg)
    {
        $server = "127.0.0.1";     // Mudar depois
        $port = 1883;                     // Mudar depois\
        $username = "";                   // Mudar depois
        $password = "";                   // Mudar depois
        $client_id = "phpMQTT-publisher";
        $mqtt = new phpMQTT($server, $port, $client_id);
        if ($mqtt->connect(true, NULL, $username, $password)) {
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();

        } else {
            file_put_contents("debug.output", "Time out!");
        }

    }

}