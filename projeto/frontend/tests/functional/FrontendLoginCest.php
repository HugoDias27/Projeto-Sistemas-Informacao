<?php


namespace frontend\tests\Functional;

use frontend\tests\FunctionalTester;

class FrontendLoginCest
{

    protected function _before(FunctionalTester $I)
    {
        $I->amOnRoute('/');
        $I->see('Bem-Vindo à Carolo Farmacêutica!');
    }

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