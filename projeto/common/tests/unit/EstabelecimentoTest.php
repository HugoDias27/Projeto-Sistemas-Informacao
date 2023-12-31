<?php

namespace common\tests\unit;

use backend\models\Estabelecimento;
use common\tests\UnitTester;

class EstabelecimentoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testValidation()
    {
        $estabelecimento = new Estabelecimento();

        $estabelecimento->nome = 'Um nome muito longo que ultrapassa o limite permitido para o campo de nome';
        $this->assertFalse($estabelecimento->validate());

        $estabelecimento->morada = 'Uma morada muito extensa que ultrapassa o limite permitido para o campo de morada';
        $this->assertFalse($estabelecimento->validate());

        $estabelecimento->telefone = 'Este é um texto em vez de um número de telefone';
        $this->assertFalse($estabelecimento->validate());

        $estabelecimento->email = 'umemailemail.com';
        $this->assertFalse($estabelecimento->validate());
    }


    public function testSavingEstabelecimento()
    {
        $estabelecimento = new Estabelecimento();

        $estabelecimento->nome = 'Teste';
        $estabelecimento->morada = 'ola';
        $estabelecimento->telefone = 924567894;
        $estabelecimento->email = 'teste@teste.pt';

        $estabelecimento->save();

        $this->tester->seeInDatabase('estabelecimentos', ['nome' => 'Teste']);
    }

    public function testUpdateEstabelecimento()
    {
        $estabelecimento = Estabelecimento::find()->where(['nome' => 'Teste'])->one();

        $estabelecimento->nome = 'Novo Nome';
        $estabelecimento->morada = 'Nova Morada';
        $estabelecimento->telefone = 987654321;
        $estabelecimento->email = 'teste@teste2.pt';

        $estabelecimento->save();

        $this->tester->seeInDatabase('estabelecimentos', ['nome' => 'Novo Nome']);
    }

    public function testDeleteEstabelecimento()
    {
        $deletedRows = Estabelecimento::deleteAll(['nome' => 'Novo Nome']);
        $this->tester->assertGreaterThan(0, $deletedRows, 'Nenhum registo foi apagado');

    }

}
