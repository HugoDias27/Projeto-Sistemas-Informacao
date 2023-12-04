<?php

use common\models\ReceitaMedica;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ReceitaMedicaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Receita Medicas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receita-medica-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Receita Medica', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nome',
            'codigo',
            'local_prescricao',
            'medico_prescricao',
            //'dosagem',
            //'data_validade',
            //'telefone',
            //'valido',
            //'posologia',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ReceitaMedica $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
