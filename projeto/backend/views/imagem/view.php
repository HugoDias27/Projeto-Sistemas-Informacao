<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Imagem $imagem */

$this->title = $imagem->id;
$this->params['breadcrumbs'][] = ['label' => 'Imagems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="imagem-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $imagem->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $imagem->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Queres eliminar esta imagem?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $imagem,
        'attributes' => [
            'id',
            'filename',
            'produto_id',
            'imagem' => [
                'label' => 'Imagem',
                'format' => 'raw',
                'value' => Html::img($imageHtml, ['width' => '300px']),
            ]

        ],
    ]) ?>

</div>
