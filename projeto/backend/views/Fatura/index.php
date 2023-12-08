<?php

use common\models\Fatura;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var common\models\FaturaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Faturas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fatura-index">




    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= Html::label('Estabelecimento ID') ?>
    <?= Html::dropDownList('estabelecimento_id', $estabelecimento, $estabelecimentos, ['prompt' => 'Selecione o estabelecimento...', 'class' => 'form-control']) ?>

    <?= Html::label('Cliente ID') ?>
    <?= Html::dropDownList('cliente_id', $cliente, $clientes, ['prompt' => 'Selecione o cliente...', 'class' => 'form-control']) ?>

    <div class="form-group">
        <?= Html::submitButton('Aplicar' ,['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>
    <p>

        <?php if ($estabelecimento && $cliente) : ?>

            <?= Html::a('Create Primeira', ['linha/createprimeira', 'estabelecimento_id' => $estabelecimento, 'cliente_id' => $cliente], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'dta_emissao',
            'loja',
            'emissor',
            'total_fatura',
            //'cliente_id',
            //'receita_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Fatura $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
