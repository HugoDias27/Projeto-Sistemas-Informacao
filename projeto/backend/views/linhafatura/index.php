<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\LinhaFatura $linhafatura */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Linha Fatura';
$this->params['breadcrumbs'][] = $this->title;

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
                            De:
                            <address>
                                <?= Html::a('<strong>Nome:</strong> ' . $estabelecimento->nome) ?>
                                <?= Html::a('<br>') ?>
                                <?= Html::a('<strong>Morada:</strong> ' . $estabelecimento->morada) ?>
                                <?= Html::a('<br>') ?>
                                <?= Html::a('<strong>Telefone:</strong> ' . $estabelecimento->telefone) ?>
                                <?= Html::a('<br>') ?>
                                <?= Html::a('<strong>Email:</strong> ' . $estabelecimento->email) ?>
                            </address>
                        </div>
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
                            <?= Html::a($fatura_id) ?>
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
                                    <th>Preço Unit.</th>
                                    <th>IVA</th>
                                    <th>Valor</th>
                                    <th>Valor Total</th>
                                    <th>Ações</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($totallinhas as $linhafatura) { ?>
                                <?php foreach ($servicos as $servico) { ?>
                                <tr>
                                    <?php if(isset($linhafatura)) {?>
                                    <td><?= Html::encode($servico->nome) ?></td>
                                    <td>
                                        <?php $form = ActiveForm::begin([
                                            'action' => ['update', 'id' => $linhafatura->id],
                                            'method' => 'post',
                                        ]); ?>

                                        <?= Html::input('number', 'quantidade', $linhafatura->quantidade, ['class' => 'form-control']) ?>
                                        <?= Html::submitButton('Atualizar Quantidade', ['class' => 'btn btn-primary']) ?>

                                        <?php ActiveForm::end(); ?>
                                    </td>

                                    <td><?= Html::encode($linhafatura->precounit) ?></td>
                                    <td><?= Html::encode($linhafatura->valoriva) ?></td>
                                    <td><?= Html::encode($linhafatura->valorcomiva) ?></td>
                                    <td><?= Html::encode($linhafatura->subtotal) ?></td>
                                    <td>
                                        <?php $form = ActiveForm::begin([
                                            'action' => ['delete', 'id' => $linhafatura->id, 'fatura_id' => $linhafatura->fatura_id, 'estabelecimento' => $estabelecimento->id, 'cliente' => $cliente->id, 'servico_id' => $linhafatura->servico_id,],
                                            'method' => 'post',
                                        ]); ?>
                                        <?= Html::submitButton('Eliminar', ['class' => 'btn btn-danger']) ?>
                                        <?php ActiveForm::end();} ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php } ?>
                                <tr>
                                    <td><?= Html::a('Criar Linha',['linhafatura/create','id_fatura' => $fatura_id, 'estabelecimento_id' => $estabelecimento->id ], ['class' => 'btn btn-success']) ?></td>
                                </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>

                    <!-- Informações de pagamento -->
                    <div class="row">
                        <div class="col-6">
                            <?= Html::a('Concluir Fatura',['fatura/update', 'id'=> $fatura_id ], ['class' => 'btn btn-warning']);?>
                            <!-- Coluna de pagamentos aceitos -->
                        </div>
                        <div class="col-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td> <?= $fatura->valortotal - $fatura->ivatotal?></td>
                                    </tr>
                                    <tr>
                                        <th>IVA:</th>
                                        <td> <?= $fatura->ivatotal?></td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td><?= $fatura->valortotal?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
</section>
