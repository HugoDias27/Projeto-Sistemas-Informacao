<?php
namespace common\models;

use common\models\Imagem;
use common\models\Produto;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;
    public $produto_id;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, webp', 'maxFiles' => 4],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                $imageName = $file->baseName . '.' . $file->extension;
                $image = new Imagem();
                $image->filename = $imageName;
                $image->produto_id = $this->produto_id;
                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
                $image->save(false);
            }
            return true;
        } else {
            return false;
        }
    }
}
