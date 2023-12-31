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
        <?= Html::a('Criar fatura', ['create'], ['class' => 'btn btn-success']) ?>
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
                    'label' => 'Valor Total',
                'attribute' => 'valortotal',
                'value' => function (Fatura $model) {
                    return $model->valortotal . '€';
                }
            ],
            'ivatotal' => [
                    'label' => 'IVA Total',
                'attribute' => 'ivatotal',
                'value' => function (Fatura $model) {
                    return $model->ivatotal . '€';
                }
            ],
            'cliente_id' => [
                'label' => 'Cliente',
                'attribute' => 'cliente_id',
                'value' => function (Fatura $model) {
                    return $model->user ? $model->user->username : 'N/A';
                }
            ],
            'estabelecimento_id' => [
                'label' => 'Estabelecimento',
                'attribute' => 'estabelecimento_id',
                'value' => function (Fatura $model) {
                    return $model->estabelecimento ? $model->estabelecimento->nome : 'N/A';
                }
            ],
            'emissor_id' => [
                'label' => 'Emissor',
                'attribute' => 'emissor_id',
                'value' => function (Fatura $model) {
                    return $model->emissor && $model->emissor->user ? $model->emissor->user->username : 'N/A';
                }
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete}', // Remove 'update' from the template
                'urlCreator' => function ($action, Fatura $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
            ],

        ],
    ]); ?>


</div>