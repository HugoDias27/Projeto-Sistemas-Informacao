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
        <?= Html::a('Update', ['update', 'id' => $produto->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $produto->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $produto,
        'attributes' => [
            'id',
            'nome',
            'prescricao_medica',
            'preco',
            'quantidade',
            'categoria_id',
            'iva_id',
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


    <!-- Exibir imagens associadas ao produto -->
    <h2>Imagens:</h2>
    <?php foreach ($imagemArray as $imagem): ?>
        <?= Html::img($imagem, ['width' => '300px']); ?>
    <?php endforeach; ?>

</div>
