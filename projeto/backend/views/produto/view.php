<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Produto $produto */

$this->title = $produto->nome;
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="produto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $produto->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $produto->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Queres eliminar este produto?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $produto,
        'attributes' => [
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
            [
                'attribute' => 'iva_id',
                'label' => 'IVA',
                'value' => function ($model) {
                    return isset($model->iva) ? $model->iva->percentagem . '%' : '';
                },
            ],
            'quantidade',
        ],
    ]) ?>
    <h2>Detalhes dos Fornecedores:</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Nome do Fornecedor</th>
            <th>Data do Fornecedor</th>
            <th>Hora do Fornecedor</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($fornecedorProduto as $fornecedor): ?>
            <tr>
                <td><?= $fornecedor->fornecedor->nome ?></td>
                <td><?= $fornecedor->data_importacao ?></td>
                <td><?= $fornecedor->hora_importacao ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>


    <h2>Imagens:</h2>
    <?php foreach ($imagemArray as $imagem): ?>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <div style="margin-right: 10px;">
                <?= Html::img($imagem['filename'], ['width' => '300px']); ?>
            </div>
            <div>
                <?= Html::a('Apagar Imagem', ['imagem/delete', 'id' => $imagem['id']], [
                    'data' => [
                        'confirm' => 'Tem certeza que deseja apagar esta imagem?',
                        'method' => 'post',
                    ],
                    'class' => 'btn btn-danger',
                ]); ?>
            </div>
        </div>
    <?php endforeach; ?>



