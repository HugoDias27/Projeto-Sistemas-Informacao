<?php


namespace common\tests\unit;

use common\models\Iva;
use common\tests\UnitTester;

class IvaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testValidation()
    {
        //Teste de validação dos campos com dados errados
        $iva = new Iva();

        $iva->percentagem = 'ABC';
        $this->assertFalse($iva->validate(['percentagem']));

        $iva->vigor = 'Texto';
        $this->assertFalse($iva->validate(['vigor']));

        $iva->descricao = 'Uma descrição muito longa que ultrapassa o limite de 60 caracteres';
        $this->assertFalse($iva->validate(['descricao']));

    }

    public function testIva()
    {
        //Teste de inserção dos dados na tabela ivas
        $iva = new Iva();
        $iva->setPercentagem(23);
        $iva->setVigor(1);
        $iva->setDescricao('teste');
        $this->assertTrue($iva->save());


        //Teste de atualização dos dados na tabela ivas
        $iva = Iva::find()->where(['descricao' => 'teste'])->one();
        $iva->percentagem = 13;
        $iva->vigor = 0;
        $iva->descricao = 'teste2';
        $this->assertTrue($iva->save());

        //Teste de apagar os dados na tabela ivas
        $deletedRows = Iva::deleteAll(['descricao' => 'teste2']);
        $this->tester->assertGreaterThan(0, $deletedRows, 'Nenhum registo foi apagado');
    }
}