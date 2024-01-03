<?php


namespace common\tests\Unit;

use common\models\Categoria;
use common\tests\UnitTester;
use Yii;

class CategoriaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testValidation()
    {
        $categoria = new Categoria();

        $categoria->descricao = 22;
        $this->assertFalse($categoria->validate());
    }


    public function testSavingCategoria()
    {
        $categoria = new Categoria();

        $categoria->descricao = 'Descrição categoria';

        $categoria->save();

        $this->tester->seeInDatabase('categorias', ['descricao' => 'Descrição categoria']);
    }

    public function testDeleteCategoria()
    {
        $deletedRows = Categoria::deleteAll(['descricao' => 'Descrição categoria']);
        $this->tester->assertGreaterThan(0, $deletedRows, 'Nenhum registo foi apagado');

    }
}
