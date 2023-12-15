<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \backend\models\ServicoEstabelecimento $servicoEstabelecimento */

$this->title = 'Criar Serviço Estabelecimento';
$this->params['breadcrumbs'][] = ['label' => 'Serviço Estabelecimentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servico-estabelecimento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'servicoEstabelecimento' => $servicoEstabelecimento, 'servicos' => $servicos, 'estabelecimentos' => $estabelecimentos,
    ]) ?>

</div>
