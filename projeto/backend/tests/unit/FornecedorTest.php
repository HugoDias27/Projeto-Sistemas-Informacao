<?php


namespace backend\tests\Unit;

use backend\models\Fornecedor;
use backend\tests\UnitTester;
use Yii;

class FornecedorTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testValidation()
    {
        $fornecedor = new Fornecedor();

        $fornecedor->nome = 22;
        $this->assertFalse($fornecedor->validate());
        $fornecedor->telefone = 'flvudgsvgjh';
        $this->assertFalse($fornecedor->validate());
        $fornecedor->email = 475737;
        $this->assertFalse($fornecedor->validate());
    }


    public function testSavingFornecedor()
    {
        $fornecedor = new Fornecedor();

        $fornecedor->nome = 'Teste Fornecedor';
        $fornecedor->telefone = 916743092;
        $fornecedor->email = 'teste@teste.pt';

        $fornecedor->save();

        $this->tester->seeInDatabase('fornecedores', ['nome' => 'Teste Fornecedor']);
    }

    public function testDeleteFornecedor()
    {
        $deletedRows = Fornecedor::deleteAll(['nome' => 'Teste Fornecedor']);
        $this->tester->assertGreaterThan(0, $deletedRows, 'Nenhum registo foi apagado');

    }
}
