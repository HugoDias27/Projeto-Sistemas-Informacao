<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Fatura $fatura */


$this->title = 'Create fatura';
$this->params['breadcrumbs'][] = ['label' => 'Faturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fatura-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'fatura' => $fatura, 'estabelecimento' => $estabelecimento, 'cliente' => $cliente,
    ]) ?>

</div>
