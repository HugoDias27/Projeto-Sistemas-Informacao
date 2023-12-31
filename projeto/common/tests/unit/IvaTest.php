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
        $iva = new Iva();

        $iva->percentagem = 'ABC';
        $this->assertFalse($iva->validate(['percentagem']));

        $iva->vigor = 'Texto';
        $this->assertFalse($iva->validate(['vigor']));

        $iva->descricao = 'Uma descrição muito longa que ultrapassa o limite de 60 caracteres';
        $this->assertFalse($iva->validate(['descricao']));

    }

    public function testSavingIva()
    {
        $iva = new Iva();

        $iva->setPercentagem(23);
        $iva->setVigor(1);
        $iva->setDescricao('teste');

        $iva->save();

        $this->tester->seeInDatabase('ivas', ['descricao' => 'teste']);
    }

    public function testUpdateIva()
    {
        $iva = Iva::find()->where(['descricao' => 'teste'])->one();

        $iva->percentagem = 13;
        $iva->vigor = 0;
        $iva->descricao = 'teste2';

        $iva->save();

        $this->tester->seeInDatabase('ivas', ['descricao' => 'teste2']);
    }


    public function testDeleteIva()
    {
        $deletedRows = Iva::deleteAll(['descricao' => 'teste2']);
        $this->tester->assertGreaterThan(0, $deletedRows, 'Nenhum registo foi apagado');

    }

}
