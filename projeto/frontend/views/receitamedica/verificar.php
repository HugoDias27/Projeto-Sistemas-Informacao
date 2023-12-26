<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ReceitaMedica $receitaMedica */

$this->title = 'Verificar Receita Medica';
$this->params['breadcrumbs'][] = ['label' => 'Receita Medicas', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = $this->title;
$flashMessages = Yii::$app->session->getAllFlashes();

?>
<div class="receita-medica-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'receitaMedica' => $receitaMedica,
    ]) ?>

</div>
