<?php

use backend\models\ServicoEstabelecimento;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var \backend\models\ServicoEstabelecimentoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Servico Estabelecimentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servico-estabelecimento-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Servico Estabelecimento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'estabelecimento_id',
                'value' => function ($model) {
                    return $model->estabelecimento->nome;
                },
            ],
            [
                'attribute' => 'servico_id',
                'value' => function ($model) {
                    return $model->servico->nome;
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ServicoEstabelecimento $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'estabelecimento_id' => $model->estabelecimento_id, 'servico_id' => $model->servico_id]);
                },
            ],
        ],
    ]); ?>



</div>
