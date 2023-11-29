<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Imagem extends ActiveRecord
{
    public $imagem;

    public static function tableName()
    {
        return 'imagens';
    }

    public function rules()
    {
        return [
            [['filename'], 'file', 'skipOnEmpty' => false, 'extensions'=>'png,jpg', 'maxFiles' => 3],
            [['filename', 'produto_id'], 'required'],
            [['produto_id'], 'integer'],
            [['filename'], 'string', 'max' => 60],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Filename',
            'produto_id' => 'Produto ID',
        ];
    }

    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['id' => 'produto_id']);
    }

    public function upload($produtoId)
    {
        if ($this->validate()) {
            foreach ($this->imagem as $file) {
                $newImagem = new Imagem();
                $newImagem->filename = $file->baseName . '.' . $file->extension;
                $newImagem->produto_id = $produtoId;
                $newImagem->save();

                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }
}

