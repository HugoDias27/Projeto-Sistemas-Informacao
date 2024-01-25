<?php

use common\models\ReceitaMedica;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\ReceitaMedica $receita */

$this->title = 'Receita: '.$receita->codigo;
$this->params['breadcrumbs'][] = ['label' => 'Receita Médica', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="receita-medica-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Eliminar', ['delete', 'id' => $receita->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Queres eliminar esta receita?',
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
            'posologia' => [
                'attribute' => 'posologia',
                'value' => function (ReceitaMedica $model) {
                    return $model->posologiaProduto->nome;
                }
            ]
        ],
    ]) ?>

</div>
