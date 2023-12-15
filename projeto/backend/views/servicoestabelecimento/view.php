<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var \backend\models\ServicoEstabelecimento $servicoEstabelecimento */

$this->title = $servicoEstabelecimento->estabelecimento_id;
$this->params['breadcrumbs'][] = ['label' => 'Servico Estabelecimentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="servico-estabelecimento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'estabelecimento_id' => $servicoEstabelecimento->estabelecimento_id, 'servico_id' => $servicoEstabelecimento->servico_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'estabelecimento_id' => $servicoEstabelecimento->estabelecimento_id, 'servico_id' => $servicoEstabelecimento->servico_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $servicoEstabelecimento,
        'attributes' => [
            'estabelecimento_id' => [
                'attribute' => 'Percentagem de Iva',
                'value' => $nomeServico
            ],'servico_id' => [
                'attribute' => 'Percentagem de Iva',
                'value' => $nomeEstabelecimento
            ],
        ],
    ]) ?>

</div>
