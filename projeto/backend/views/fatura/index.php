<?php

use common\models\Fatura;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\FaturaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Faturas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fatura-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <p>
        <?= Html::a('Create Fatura', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'dta_emissao',
            'valortotal' => [
                'attribute' => 'valortotal',
                'value' => function (Fatura $model) {
                    return $model->valortotal . '€';
                }
            ],
            'ivatotal' => [
                'attribute' => 'ivatotal',
                'value' => function (Fatura $model) {
                    return $model->ivatotal . '€';
                }
            ],
            'cliente_id' => [
                'attribute' => 'cliente_id',
                'value' => function (Fatura $model) {
                    return $model->user->username;
                }
            ],
            'estabelecimento_id' => [
                'attribute' => 'estabelecimento_id',
                'value' => function (Fatura $model) {
                    return $model->estabelecimento->nome;
                }
            ],
            'emissor_id' => [
                'attribute' => 'emissor_id',
                'value' => function (Fatura $model) {
                    return $model->emissor->user->username;
                }
            ],

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Fatura $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>