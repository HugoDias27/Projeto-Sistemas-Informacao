<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Fatura $fatura */

$this->title = $fatura->id;
$this->params['breadcrumbs'][] = ['label' => 'Faturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="invoice p-3 mb-3" style="position: relative;">
                    <div style="position: absolute; top: 10px; right: 10px;">
                        <?= Html::img('@web/logo.png', ['alt' => 'Imagem', 'style' => 'float: right; width: 150px; height: 100px;']) ?>
                    </div>
                    <div class="row">
                        <div class="col-12 text-right">
                            <h4>
                                <small><?= date('d-m-Y'); ?></small>
                                <br>
                                <strong>Carolo Farmacêutica</strong>
                            </h4>
                        </div>
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-6"> <!-- Adicione uma coluna maior para os dados do cliente -->
                            <address>
                                <?= '<strong>Nome:</strong> ' . $cliente->username ?>
                                <?= Html::a('<br>') ?>
                                <?= '<strong>Email:</strong> ' . $cliente->email ?>
                                <?= Html::a('<br>') ?>
                                <?= '<strong>Telefone:</strong> ' . $perfilCliente->telefone ?>
                                <?= Html::a('<br>') ?>
                                <?= '<strong>Nif:</strong> ' . $perfilCliente->nif ?>
                                <?= Html::a('<br>') ?>
                                <?= '<strong>Morada:</strong> ' . $perfilCliente->morada ?>
                                <?= Html::a('<br>') ?>
                                <?= '<strong>Nif:</strong> ' . $perfilCliente->n_utente ?>
                            </address>
                        </div>
                        <div class="col-sm-6"> <!-- Adicione uma coluna maior para os detalhes da fatura -->
                            <div class="col-12">
                                <?= Html::a('<strong>Fatura nº:</strong> ') ?>
                                <?= Html::a($fatura->id) ?>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Descrição</th>
                                    <th>Quantidade</th>
                                    <th>Preço Unitário</th>
                                    <th>IVA</th>
                                    <th>Valor</th>
                                    <th>Valor Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($linhasFatura as $linhafatura) { ?>
                                    <?php if ($linhafatura->servico_id != null) { ?>
                                        <?php foreach ($servicos as $servico) { ?>
                                            <tr>
                                                <?php if (isset($linhafatura)) { ?>
                                                    <td><?= Html::encode($servico->nome) ?></td>
                                                    <td><?= Html::encode($linhafatura->quantidade) ?></td>
                                                    <td><?= Html::encode($linhafatura->precounit) ?></td>
                                                    <td><?= Html::encode($linhafatura->valoriva) ?></td>
                                                    <td><?= Html::encode($linhafatura->valorcomiva) ?></td>
                                                    <td><?= Html::encode($linhafatura->subtotal) ?></td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    <?php } else if ($linhafatura->receita_medica_id != null) { ?>
                                        <?php foreach ($receitas as $receita) { ?>
                                            <tr>
                                                <?php if (isset($linhafatura)) { ?>
                                                    <td><?= Html::encode($receita->codigo) ?></td>
                                                    <td><?= Html::encode($linhafatura->quantidade) ?></td>
                                                    <td><?= Html::encode($linhafatura->precounit) ?></td>
                                                    <td><?= Html::encode($linhafatura->valoriva) ?></td>
                                                    <td><?= Html::encode($linhafatura->valorcomiva) ?></td>
                                                    <td><?= Html::encode($linhafatura->subtotal) ?></td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php if (!empty($produtos)) : ?>
                                    <?php foreach ($linhasCarrinho as $linhaCarrinho) : ?>
                                        <tr>
                                            <td>
                                                <?php
                                                $produtoEncontrado = null;
                                                foreach ($produtos as $produto) {
                                                    if ($produto->id === $linhaCarrinho->produto_id) {
                                                        $produtoEncontrado = $produto;
                                                        break;
                                                    }
                                                }
                                                if ($produtoEncontrado !== null) {
                                                    echo Html::encode($produtoEncontrado->nome);
                                                }
                                                ?>
                                            </td>
                                            <td><?= Html::encode($linhaCarrinho->quantidade) ?></td>
                                            <td><?= Html::encode($linhaCarrinho->precounit) ?></td>
                                            <td><?= Html::encode($linhaCarrinho->valoriva) ?></td>
                                            <td><?= Html::encode($linhaCarrinho->valorcomiva) ?></td>
                                            <td><?= Html::encode($linhaCarrinho->subtotal) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Informações de pagamento -->
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td><?= $fatura->valortotal - $fatura->ivatotal ?></td>
                                    </tr>
                                    <tr>
                                        <th>IVA:</th>
                                        <td><?= $fatura->ivatotal ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td><?= $fatura->valortotal ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
