<?php

use common\models\LinhaCarrinho;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\LinhaCarrinhoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Adicionar ao Carrinho de Compras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linha-carrinho-index">

    <h1 align="center"><?= Html::encode($this->title) ?></h1>
    <hr>

    <?php $form = ActiveForm::begin(); ?>

    <?php if (!empty ($quantidadeDisponivel)): ?>
        <?= $form->field($model, 'quantidade')->dropDownList(range(1, $quantidadeDisponivel), ['prompt' => 'Selecione a quantidade...']) ?>

        <div class="form-group">
            <br>
            <p>
                <?= Html::a('Adicionar Artigo ao Carrinho', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
    <?php else: ?>
        <div align="center">
            <br>
            <h3 style="color: #f54242;">SEM STOCK!</h3>
        </div>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>


</div>
