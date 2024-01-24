<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Categoria $categoria */

$this->title = 'Update Categoria: ' . $categoria->id;
$this->params['breadcrumbs'][] = ['label' => 'Categorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $categoria->id, 'url' => ['view', 'id' => $categoria->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="categoria-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'categoria' => $categoria, 'categorias' => $categorias
    ]) ?>

</div>
