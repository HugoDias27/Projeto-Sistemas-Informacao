<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Fornecedor $fornecedor */

$this->title = $fornecedor->nome;
$this->params['breadcrumbs'][] = ['label' => 'Fornecedors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fornecedor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $fornecedor->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $fornecedor->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Queres eliminar este fornecedor?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $fornecedor,
        'attributes' => [
            'id',
            'nome',
            'telefone',
            'email:email',
        ],
    ]) ?>

</div>
