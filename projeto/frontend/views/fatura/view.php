<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Fatura $fatura */

$this->title = $fatura->id;
$this->params['breadcrumbs'][] = ['label' => 'Faturas', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<section class="content">
    <div class='table-container'>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="invoice p-3 mb-3">
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <small class="float-right"><?= date('d-m-Y'); ?></small>
                                </h4>
                            </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                Para:
                                <?= Html::a('<br>') ?>
                                <?= Html::a('<strong>Nome:</strong> ' . $cliente->username) ?>
                                <?= Html::a('<br>') ?>
                                <?= Html::a('<strong>Email:</strong> ' . $cliente->email) ?>
                                <?= Html::a('<br>') ?>
                                <?= Html::a('<strong>Telefone:</strong> ' . $perfilCliente->telefone) ?>
                                <?= Html::a('<br>') ?>
                                <?= Html::a('<strong>Nif:</strong> ' . $perfilCliente->nif) ?>
                                <?= Html::a('<br>') ?>
                                <?= Html::a('<strong>Morada:</strong> ' . $perfilCliente->morada) ?>
                                <?= Html::a('<br>') ?>
                                <?= Html::a('<strong>Nif:</strong> ' . $perfilCliente->n_utente) ?>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <?= Html::a('<strong>Fatura nº:</strong> ') ?>
                                <?= Html::a($fatura->id) ?>
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

                                                    </tr>
                                                <?php } ?>
                                            <?php }
                                        } else if ($linhafatura->receita_medica_id != null) {
                                            foreach ($receitas as $receita) { ?>
                                                <tr>
                                                <?php if (isset($linhafatura)) { ?>
                                                    <td><?= Html::encode($receita->codigo) ?></td>
                                                    <td><?= Html::encode($linhafatura->quantidade) ?></td>
                                                    <td><?= Html::encode($linhafatura->precounit) ?></td>
                                                    <td><?= Html::encode($linhafatura->valoriva) ?></td>
                                                    <td><?= Html::encode($linhafatura->valorcomiva) ?></td>
                                                    <td><?= Html::encode($linhafatura->subtotal) ?></td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php }
                                    } ?>
                                    <?php foreach ($linhasCarrinho as $linhaCarrinho) : ?>
                                        <tr>
                                            <td>
                                                <?php
                                                $produtoEncontrado = null;
                                                foreach ($produtos as $produto) {
                                                    $produtoEncontrado = $produto;
                                                }
                                                echo Html::encode($produtoEncontrado->nome); // Suponha que 'nome' seja um atributo do produto
                                                ?>
                                            </td>
                                            <td><?= Html::encode($linhaCarrinho->quantidade) ?></td>
                                            <td><?= Html::encode($linhaCarrinho->precounit) ?></td>
                                            <td><?= Html::encode($linhaCarrinho->valoriva) ?></td>
                                            <td><?= Html::encode($linhaCarrinho->valorcomiva) ?></td>
                                            <td><?= Html::encode($linhaCarrinho->subtotal) ?></td>

                                        </tr>
                                    <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Informações de pagamento -->
                        <div class="row">
                            <div class="col-6">
                            </div>
                            <div class="col-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td> <?= $fatura->valortotal - $fatura->ivatotal ?></td>
                                        </tr>
                                        <tr>
                                            <th>IVA:</th>
                                            <td> <?= $fatura->ivatotal ?></td>
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
                <!-- Botão para imprimir a fatura -->
                <div class="row">
                    <div class="col-12">
                        <?php echo Html::a(
                            'Imprimir Fatura',
                            ['imprimir', 'id' => $fatura->id],
                            ['class' => 'btn btn-primary']
                        ); ?>
                    </div>
                </div>