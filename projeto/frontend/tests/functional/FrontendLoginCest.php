<?php


namespace frontend\tests\Functional;

use frontend\tests\FunctionalTester;

class FrontendLoginCest
{
    // Teste de inicialização antes de começar os testes
    protected function _before(FunctionalTester $I)
    {
        $I->amOnRoute('/');
        $I->see('Bem-Vindo à Carolo Farmacêutica!');
    }

    // Teste de verificar a condição se os campos de login ficarem vazios
    public function signinWithEmptyFields(FunctionalTester $I)
    {
        $I->amOnRoute('/');
        $I->see('Bem-Vindo à Carolo Farmacêutica!');
        $I->click('Login');
        $I->see('Please fill out the following fields to login:');
        $I->click('login-button');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    // Teste de verficar a condição for inserido uma password inválida
    public function signinWithWrongPassword(FunctionalTester $I)
    {
        $I->amOnRoute('/');
        $I->see('Bem-Vindo à Carolo Farmacêutica!');
        $I->click('Login');
        $I->see('Please fill out the following fields to login:');
        $I->fillField('#username', 'Tiago Saramago');
        $I->fillField('#password', 'tiago.saramago2fgfg023');
        $I->click('login-button');
        $I->see('Incorrect username or password.');
    }

    // Teste de verificar a condição quando é inserido um utilizador válido
    public function signinSuccessfully(FunctionalTester $I)
    {
        $I->amOnRoute('/');
        $I->see('Bem-Vindo à Carolo Farmacêutica!');
        $I->click('Login');
        $I->see('Please fill out the following fields to login:');
        $I->fillField('#username', 'Tiago Saramago');
        $I->fillField('#password', 'tiago.saramago2023');
        $I->click('login-button');
        $I->see('Logout (Tiago Saramago)');
    }

}