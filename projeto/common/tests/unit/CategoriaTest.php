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
        //Teste de validação dos campos com dados errados
        $categoria = new Categoria();

        $categoria->descricao = 22;
        $this->assertFalse($categoria->validate());
    }


    public function testCategoria()
    {
        //Teste de inserção dos dados na tabela categorias
        $categoria = new Categoria();
        $categoria->descricao = 'Descricao categoria';
        $categoria->save();

        //Teste de atualização dos dados na tabela categorias
        $categoria = Categoria::find()->where(['descricao' => 'Descricao categoria'])->one();
        $categoria->descricao = 'Descricao categoria update';
        $categoria->save();

        //Teste de apagar os dados na tabela categorias
        $deletedRows = Categoria::deleteAll(['descricao' => 'Descricao categoria update']);
        $this->tester->assertGreaterThan(0, $deletedRows, 'Nenhum registo foi apagado');
    }

}