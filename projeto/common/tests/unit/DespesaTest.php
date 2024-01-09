<?php

namespace common\tests\unit;

use backend\models\Despesa;
use common\tests\UnitTester;

class DespesaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testValidation()
    {
        //Teste de validação dos campos com dados errados
        $despesa = new Despesa();

        $despesa->preco = 'Um nome muito longo que ultrapassa o limite permitido para o campo de nome';
        $this->assertFalse($despesa->validate());

        $despesa->dta_despesa = 7485736893;
        $this->assertFalse($despesa->validate());

        $despesa->descricao = 454374783;
        $this->assertFalse($despesa->validate());

        $despesa->estabelecimento_id = 'umemailemail.com';
        $this->assertFalse($despesa->validate());
    }


    public function testDespesa()
    {
        //Teste de inserção dos dados na tabela despesas
        $despesa = new Despesa();
        $despesa->preco = 20.0;
        $despesa->dta_despesa = '2021-05-05';
        $despesa->descricao = 'teste';
        $despesa->estabelecimento_id = 1;
        $despesa->save();

        //Teste de atualização dos dados na tabela despesas

        $despesa = Despesa::find()->where(['descricao' => 'teste'])->one();
        $despesa->preco = 40.0;
        $despesa->dta_despesa = '2021-06-06';
        $despesa->descricao = 'testeupdate';
        $despesa->estabelecimento_id = 1;
        $despesa->save();

        //Teste de apagar os dados na tabela despesas
        $deletedRows = Despesa::deleteAll(['descricao' => 'testeupdate']);
        $this->tester->assertGreaterThan(0, $deletedRows, 'Nenhum registo foi apagado');

    }
}