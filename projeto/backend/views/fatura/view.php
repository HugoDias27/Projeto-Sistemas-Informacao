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
                            <?= Html::a('De:') ?>
                            <address>
                                <?= Html::a('<strong>Nome:</strong> ' . (isset($estabelecimento->nome) ? Html::encode($estabelecimento->nome) : 'Nome não disponível')) ?>
                                <?= Html::a('<br>') ?>
                                <?= Html::a('<strong>Morada:</strong> ' . (isset($estabelecimento->morada) ? Html::encode($estabelecimento->morada) : 'Morada não disponível')) ?>
                                <?= Html::a('<br>') ?>
                                <?= Html::a('<strong>Telefone:</strong> ' . (isset($estabelecimento->telefone) ? Html::encode($estabelecimento->telefone) : 'Telefone não disponível')) ?>
                                <?= Html::a('<br>') ?>
                                <?= Html::a('<strong>Email:</strong> ' . (isset($estabelecimento->email) ? Html::encode($estabelecimento->email) : 'Email não disponível')) ?>
                            </address>
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <?= Html::a('Para:') ?>
                            <?= Html::a('<br>') ?>
                            <?= Html::a('<strong>Nome:</strong> ' . (isset($cliente->username) ? Html::encode($cliente->username) : 'Nome não disponível')) ?>
                            <?= Html::a('<br>') ?>
                            <?= Html::a('<strong>Email:</strong> ' . (isset($cliente->email) ? Html::encode($cliente->email) : 'Email não disponível')) ?>
                            <?= Html::a('<br>') ?>
                            <?= Html::a('<strong>Telefone:</strong> ' . (isset($perfilCliente->telefone) ? Html::encode($perfilCliente->telefone) : 'Telefone não disponível')) ?>
                            <?= Html::a('<br>') ?>
                            <?= Html::a('<strong>Nif:</strong> ' . (isset($perfilCliente->nif) ? Html::encode($perfilCliente->nif) : 'Nif não disponível')) ?>
                            <?= Html::a('<br>') ?>
                            <?= Html::a('<strong>Morada:</strong> ' . (isset($perfilCliente->morada) ? Html::encode($perfilCliente->morada) : 'Morada não disponível')) ?>
                            <?= Html::a('<br>') ?>
                            <?= Html::a('<strong>Número de Utente:</strong> ' . (isset($perfilCliente->n_utente) ? Html::encode($perfilCliente->n_utente) : 'Número de Utente não disponível')) ?>

                            <br>
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
                                    <th>Descrição do Serviço</th>
                                    <th>Quantidade</th>
                                    <th>Preço Unitário</th>
                                    <th>IVA</th>
                                    <th>Valor</th>
                                    <th>Valor Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($totallinhas as $linhafatura) : ?>
                                    <?php if ($linhafatura->servico_id != null) : ?>
                                        <tr>
                                            <td><?= Html::encode($linhafatura->servico->nome) ?></td>
                                            <td><?= Html::encode($linhafatura->quantidade) ?></td>
                                            <td><?= Html::encode($linhafatura->precounit) ?></td>
                                            <td><?= Html::encode($linhafatura->valoriva) ?></td>
                                            <td><?= Html::encode($linhafatura->valorcomiva) ?></td>
                                            <td><?= Html::encode($linhafatura->subtotal) ?></td>
                                        </tr>
                                    <?php elseif ($linhafatura->receita_medica_id != null) : ?>
                                        <tr>
                                            <?php if ($linhafatura->receitaMedica !== null) : ?>
                                                <td><?= Html::encode($linhafatura->receitaMedica->codigo) ?></td>
                                                <td><?= Html::encode($linhafatura->quantidade) ?></td>
                                                <td><?= Html::encode($linhafatura->precounit) ?></td>
                                                <td><?= Html::encode($linhafatura->valoriva) ?></td>
                                                <td><?= Html::encode($linhafatura->valorcomiva) ?></td>
                                                <td><?= Html::encode($linhafatura->subtotal) ?></td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>

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
                        <div class="col-6">
                            <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-primary']) ?>
                            <?php echo Html::a(
                                'Imprimir Fatura',
                                ['imprimir', 'id' => $fatura->id],
                                ['class' => 'btn btn-primary']
                            ); ?>
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
</section>