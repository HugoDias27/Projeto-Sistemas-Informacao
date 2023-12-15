<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\ReceitaMedica $receita */

$this->title = $receita->id;
$this->params['breadcrumbs'][] = ['label' => 'Receita Médica', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="receita-medica-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $receita->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $receita->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $receita,
        'attributes' => [
            'id',
            'user.username',
            'codigo',
            'local_prescricao',
            'medico_prescricao',
            'dosagem',
            'data_validade',
            'telefone',
            'valido' => [
                'attribute' => 'valido',
                'value' => function ($model) {
                    return $model->valido ? 'Sim' : 'Não';
                },
            ],
            'posologia',
        ],
    ]) ?>

</div>
