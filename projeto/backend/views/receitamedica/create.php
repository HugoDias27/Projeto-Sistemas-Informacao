<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ReceitaMedica $receita */

$this->title = 'Criar Receita Médica';
$this->params['breadcrumbs'][] = ['label' => 'Receita Médica', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receita-medica-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'receita' => $receita, 'clientes' => $clientes,
    ]) ?>

</div>
