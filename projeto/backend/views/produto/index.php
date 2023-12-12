<?php

use common\models\Produto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ProdutoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Produtos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Produto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'nome',
            'prescricao_medica' => [
                'attribute' => 'prescricao_medica',
                'value' => function ($model) {
                    return $model->prescricao_medica ? 'Sim' : 'Não';
                },
                'filter' => [
                    0 => 'Não',
                    1 => 'Sim',
                ],
            ],
            'preco' => [
                'attribute' => 'preco',
                'value' => function ($model) {
                    return $model->preco . '€';
                },
            ],
            [
                'label' => 'Nome Fornecedor',
                'value' => function ($model) {
                    $fornecedores = '';
                    foreach ($model->fornecedores as $fornecedor) {
                        $fornecedores .= $fornecedor->nome ;
                    }
                    return $fornecedores;
                },
            ],
            [
                'label' => 'Data de Importação',
                'value' => function ($model) {
                    $fornecedores = '';
                    foreach ($model->fornecedoresProdutos as $fornecedor) {
                        $fornecedores .= $fornecedor->data_importacao ;
                    }
                    return $fornecedores;
                },
            ],
            [
                'attribute' => 'categoria_id',
                'label' => 'Categoria',
                'value' => function ($model) {
                    return isset($model->categoria) ? $model->categoria->descricao : '';
                },
            ],
            'quantidade',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {add-image}',
                'buttons' => [
                    'add-image' => function ($url, $model, $key) {
                        return Html::a(
                            '<icon class="fas fa-solid fa-image"></icon>',
                            Url::to(['imagem/create', 'produto_id' => $model->id]),
                            [
                                'title' => 'Adicionar Imagem',
                            ]
                        );
                    },
                ],
            ],

        ],
    ]); ?>

</div>
