<?php


namespace backend\tests\Functional;

use backend\tests\FunctionalTester;

class BackendLoginCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('/');
        $I->see('Sign in to start your session','p');
    }

    public function signupWithEmptyFields(FunctionalTester $I)
    {
        $I->click('Sign In');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }


    public function signupWithWrongPassword(FunctionalTester $I)
    {
        $I->fillField('#username', 'admin');
        $I->fillField('#password', '123456789');
        $I->click('Sign In');
        $I->see('Incorrect username or password.');
    }

    public function signupSuccessfully(FunctionalTester $I)
    {
        $I->fillField('#username', 'admin');
        $I->fillField('#password', 'admin*2024');
        $I->click('Sign In');

        $I->see('Carolo Farmacêutica');
    }

}
