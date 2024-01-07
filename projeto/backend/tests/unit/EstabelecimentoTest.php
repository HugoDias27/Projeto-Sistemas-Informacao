<?php


namespace backend\tests\Unit;

use backend\models\Estabelecimento;
use backend\tests\UnitTester;

class EstabelecimentoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testValidation()
    {
        //Teste de validação dos campos com dados errados
        $estabelecimento = new Estabelecimento();

        $estabelecimento->nome = 22;
        $this->assertFalse($estabelecimento->validate());
        $estabelecimento->morada = 65;
        $this->assertFalse($estabelecimento->validate());
        $estabelecimento->telefone = 'teste';
        $this->assertFalse($estabelecimento->validate());
        $estabelecimento->email = 475737;
        $this->assertFalse($estabelecimento->validate());
    }


    public function testEstabelecimento()
    {
        //Teste de inserção dos dados na tabela estabelecimentos
        $estabelecimento = new Estabelecimento();
        $estabelecimento->nome = 'Teste Estabelecimento';
        $estabelecimento->morada = 'Rua do teste';
        $estabelecimento->telefone = 916743092;
        $estabelecimento->email = 'teste@teste.pt';
        $estabelecimento->save();

        //Teste de atualização dos dados na tabela estabelecimentos
        $estabelecimento = Estabelecimento::find()->where(['nome' => 'Teste Estabelecimento'])->one();
        $estabelecimento->nome = 'Teste Estabelecimento Update';
        $estabelecimento->telefone = 930956789;
        $estabelecimento->email = 'testeupdate@teste.pt';
        $estabelecimento->save();

        //Teste de apagar os dados na tabela estabelecimentos
        $deletedRows = Estabelecimento::deleteAll(['nome' => 'Teste Estabelecimento Update']);
        $this->tester->assertGreaterThan(0, $deletedRows, 'Nenhum registo foi apagado');
    }
}