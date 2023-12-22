<?php

use common\models\Servico;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ServicoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Serviços';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servico-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'nome',
            'duracao',
            'preco',
            [
                'attribute' => 'iva_id',
                'label' => 'Percentagem de IVA',
            ],
        ],
    ]); ?>


</div>
