<?php

use common\models\ReceitaMedica;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ReceitaMedicaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Receita Médicas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receita-medica-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'codigo',
            'local_prescricao',
            'medico_prescricao',
            'dosagem',
            'data_validade',
            'telefone',
            [
                'attribute' => 'valido',
                'label' => 'Válido',
                'value' => function ($model) {
                    return $model->valido == 1 ? 'Sim' : 'Não';
                },
            ],
            [
                'attribute' => 'posologia',
                'label' => 'Nome do Produto',
                'value' => function ($model) {
                    return $model->posologiaProduto->nome;
                },
            ],

        ],
    ]); ?>

</div>
