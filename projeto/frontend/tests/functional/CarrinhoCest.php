<?php


namespace frontend\tests\Functional;

use frontend\tests\FunctionalTester;

class CarrinhoCest
{

    protected FunctionalTester $tester;

    protected function _before(FunctionalTester $I)
    {

    }

    // tests
    public function testeProdutoComReceita(FunctionalTester $I)
    {
        $I->amOnRoute('/');
        $I->see('Bem-Vindo à Carolo Farmacêutica!');
        $I->click('Login');
        $I->see('Please fill out the following fields to login:');
        $I->fillField('#username', 'Tiago Saramago');
        $I->fillField('#password', 'tiago.saramago2023');
        $I->click('login-button');
        $I->see('Logout (Tiago Saramago)');
        $I->click('Brufens');
        $I->see('Brufens');
        $I->see('Informações Técnicas');
        $I->click('carro');

       // $I->see('Verificar Receita Medica');
        $I->fillField('ReceitaMedica[codigo]', '4789');
        $I->see('Save');
        $I->click('Save');
        $I->click('Carrinho');
       // $I->see('Adicionar Produto ao Carrinho');

        //$I->fillField('quantidade', '2');

        /*$I->amOnRoute('/');
        $I->see('Bem-Vindo à Carolo Farmacêutica!');
        $I->click('Login');
        $I->see('Please fill out the following fields to login:');
        $I->fillField('#username', 'Tiago Saramago');
        $I->fillField('#password', 'tiago.saramago2023');
        $I->click('login-button');
        $I->see('Logout (Tiago Saramago)');

        $I->see('Carrinho');
        $I->click('Carrinho');*/
        $I->see('Carrinho Compras');
        $I->fillField('quantidade', '2');
        $I->click('Atualizar');
        $I->click('Concluir Carrinho');
        $I->click('Finalizar Compra');

        /*$I->see('Brufens');
         $I->fillField('quantidade', '2');
         $I->fillField('quantidade', '3');
         $I->click('Atualizar');
         $I->click('Concluir Carrinho');
         $I->click('Finalizar Compra');*/
    }

}
