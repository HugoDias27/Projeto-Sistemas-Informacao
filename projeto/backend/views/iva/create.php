<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Iva $iva */

$this->title = 'Create Iva';
$this->params['breadcrumbs'][] = ['label' => 'Ivas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="iva-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'iva' => $iva,
    ]) ?>

</div>
