<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\LinhaFatura $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Linha Faturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="linha-fatura-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Queres eliminar esta linha?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'dta_venda',
            'quantidade',
            'precounit',
            'valoriva',
            'valorcomiva',
            'subtotal',
            'fatura_id',
            'receita_medica_id',
            'servico_id',
        ],
    ]) ?>

</div>
