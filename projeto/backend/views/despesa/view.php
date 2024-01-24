<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Despesa $despesa */

$this->title = $despesa->descricao;
$this->params['breadcrumbs'][] = ['label' => 'Despesas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="despesa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $despesa->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $despesa->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Queres eliminar esta despesa?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $despesa,
        'attributes' => [
            'id',
            'preco',
            'dta_despesa',
            'descricao',
            'estabelecimento_id',
        ],
    ]) ?>

</div>
