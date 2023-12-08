<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Iva $iva */

$this->title = 'Atualizar Iva: ' . $iva->percentagem;
$this->params['breadcrumbs'][] = ['label' => 'Ivas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $iva->id, 'url' => ['view', 'id' => $iva->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="iva-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'iva' => $iva,
    ]) ?>

</div>
