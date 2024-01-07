<?php


namespace backend\tests\Functional;

use backend\tests\FunctionalTester;

class BackendLoginCest
{

    // Teste de inicialização antes de começar os testes
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('/');
        $I->see('Sign in to start your session','p');
    }

    // Teste de verificar a condição se os campos de login ficarem vazios
    public function signinWithEmptyFields(FunctionalTester $I)
    {
        $I->click('Sign In');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }


    // Teste de verficar a condição for inserido uma password inválida
    public function signinWithWrongPassword(FunctionalTester $I)
    {
        $I->fillField('#username', 'admin');
        $I->fillField('#password', '123456789');
        $I->click('Sign In');
        $I->see('Incorrect username or password.');
    }

    // Teste de verificar a condição quando é inserido um utilizador válido
    public function signinSuccessfully(FunctionalTester $I)
    {
        $I->fillField('#username', 'admin');
        $I->fillField('#password', 'admin*2024');
        $I->click('Sign In');

        $I->see('Carolo Farmacêutica');
    }

}
