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
        //Teste de validação dos campos com dados errados
        $fornecedor = new Fornecedor();

        $fornecedor->nome = 22;
        $this->assertFalse($fornecedor->validate());
        $fornecedor->telefone = 'flvudgsvgjh';
        $this->assertFalse($fornecedor->validate());
        $fornecedor->email = 475737;
        $this->assertFalse($fornecedor->validate());
    }


    public function testFornecedor()
    {
        //Teste de inserção dos dados na tabela fornecedores
        $fornecedor = new Fornecedor();
        $fornecedor->nome = 'Teste Fornecedor';
        $fornecedor->telefone = 916743092;
        $fornecedor->email = 'teste@teste.pt';
        $fornecedor->save();

        //Teste de atualização dos dados na tabela fornecedores
        $fornecedor = Fornecedor::find()->where(['nome' => 'Teste Fornecedor'])->one();
        $fornecedor->nome = 'Teste Fornecedor Update';
        $fornecedor->telefone = 930956789;
        $fornecedor->email = 'testeupdate@teste.pt';
        $fornecedor->save();

        //Teste de apagar os dados na tabela fornecedores
        $deletedRows = Fornecedor::deleteAll(['nome' => 'Teste Fornecedor Update']);
        $this->tester->assertGreaterThan(0, $deletedRows, 'Nenhum registo foi apagado');
    }
}