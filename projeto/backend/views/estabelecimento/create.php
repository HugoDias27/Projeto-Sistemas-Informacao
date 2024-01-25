<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Estabelecimento $estabelecimento */

$this->title = 'Create Estabelecimento';
$this->params['breadcrumbs'][] = ['label' => 'Estabelecimentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estabelecimento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'estabelecimento' => $estabelecimento,
    ]) ?>

</div>
