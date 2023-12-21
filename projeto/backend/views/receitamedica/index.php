<?php

use common\models\ReceitaMedica;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ReceitaMedicaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Receitas Médicas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receita-medica-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Receita Médica', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'user_id' => [
                    'label' => 'Cliente',
                'attribute' => 'user_id',
                'value' => function (ReceitaMedica $model) {
                    return $model->user->username;
                }
            ],
            'codigo',
            'local_prescricao',
            'medico_prescricao',
            'dosagem',
            'data_validade',
            'valido' => [
                'attribute' => 'valido',
                'value' => function ($model) {
                    return $model->valido ? 'Sim' : 'Não';
                },
                'filter' => [
                    0 => 'Não',
                    1 => 'Sim',
                ],
            ],
            'posologia' => [
                'attribute' => 'posologia',
                'value' => function (ReceitaMedica $model) {
                    return $model->posologiaProduto->nome;
                }
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete}', // Define os botões de visualização e exclusão
                'urlCreator' => function ($action, ReceitaMedica $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>



</div>
