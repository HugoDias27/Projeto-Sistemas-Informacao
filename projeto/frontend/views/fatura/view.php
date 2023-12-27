<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Fatura $model */

$this->title = 'Fatura ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Faturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fatura-view">

    <h1 align="center"><?= Html::encode($this->title) ?></h1>
    <hr>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'dta_emissao',
            'valortotal',
            'ivatotal',
            //'cliente_id',
            'estabelecimento_id',
            'emissor_id',
        ],
    ]) ?>

</div>