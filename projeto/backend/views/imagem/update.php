<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Imagem $imagem */

$this->title = 'Update Imagem: ' . $imagem->id;
$this->params['breadcrumbs'][] = ['label' => 'Imagems', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $imagem->id, 'url' => ['view', 'id' => $imagem->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="imagem-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'imagem' => $imagem,
    ]) ?>

</div>
