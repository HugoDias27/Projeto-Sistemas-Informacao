<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Estabelecimento $estabelecimento */

$this->title = $estabelecimento->nome;
$this->params['breadcrumbs'][] = ['label' => 'Estabelecimentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="estabelecimento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $estabelecimento->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $estabelecimento->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $estabelecimento,
        'attributes' => [
            'id',
            'nome',
            'morada',
            'telefone',
            'email:email',
        ],
    ]) ?>

</div>
