<?php
namespace common\models;

use common\models\Imagem;
use common\models\Produto;
use common\models\GuidGenerator;
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
                $imageName = GuidGenerator::getGUID();
                $image = new Imagem();
                $image->filename = $imageName;
                $image->produto_id = $this->produto_id;

                $backendPath = 'uploads/' . $imageName . '.' . $file->extension;
                $file->saveAs($backendPath);

                $frontendPath = '..\..\frontend\web\uploads/' . $imageName . '.' . $file->extension;
                copy($backendPath, $frontendPath);

                $image->save(false);
            }
            return true;
        } else {
            return false;
        }
    }


}
