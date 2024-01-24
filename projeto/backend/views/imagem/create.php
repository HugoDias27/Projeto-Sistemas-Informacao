<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Imagem $imagem */

$this->title = 'Create Imagem';
$this->params['breadcrumbs'][] = ['label' => 'Imagems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="imagem-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'imagem' => $imagem,
    ]) ?>

</div>
