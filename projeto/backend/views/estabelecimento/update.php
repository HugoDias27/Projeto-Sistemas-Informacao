<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Estabelecimento $estabelecimento */

$this->title = 'Update Estabelecimento: ' . $estabelecimento->nome;
$this->params['breadcrumbs'][] = ['label' => 'Estabelecimentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $estabelecimento->id, 'url' => ['view', 'id' => $estabelecimento->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="estabelecimento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'estabelecimento' => $estabelecimento,
    ]) ?>

</div>
