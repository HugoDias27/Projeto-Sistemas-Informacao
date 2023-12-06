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


    <!-- Exibindo informações dos fornecedores e relação Fornecedor/Produto em tabela -->
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
        <?php foreach ($fornecedores as $index => $fornecedor): ?>
            <tr>
                <td><?= $fornecedor->nome ?></td>
                <?php if (isset($fornecedorProduto[$index])): ?>
                    <td><?= $fornecedorProduto[$index]->data_importacao ?></td>
                    <td><?= $fornecedorProduto[$index]->hora_importacao ?></td>
                <?php else: ?>
                    <td></td>
                    <td></td>
                <?php endif; ?>
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
