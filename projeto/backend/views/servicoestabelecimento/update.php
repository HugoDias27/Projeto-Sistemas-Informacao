<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \backend\models\ServicoEstabelecimento $servicoEstabelecimento */

$this->title = 'Update Servico Estabelecimento: ' . $servicoEstabelecimento->estabelecimento_id;
$this->params['breadcrumbs'][] = ['label' => 'Servico Estabelecimentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $servicoEstabelecimento->estabelecimento_id, 'url' => ['view', 'estabelecimento_id' => $servicoEstabelecimento->estabelecimento_id, 'servico_id' => $servicoEstabelecimento->servico_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="servico-estabelecimento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'servicoEstabelecimento' => $servicoEstabelecimento, 'servicos' => $servicos, 'estabelecimentos' => $estabelecimentos,
    ]) ?>

</div>
