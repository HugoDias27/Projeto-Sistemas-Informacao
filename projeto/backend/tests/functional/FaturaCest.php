<?php


namespace backend\tests\Functional;

use backend\tests\FunctionalTester;
use yii\helpers\Url;

class FaturaCest
{

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function _before(\backend\tests\FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->fillField('input[name="LoginForm[username]"]', 'seu_nome_de_usuário');
        $I->fillField('input[name="LoginForm[password]"]', 'sua_senha');
        $I->see('Sign In');
        $I->click('Sign In');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }


    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->amOnRoute('site/index');
        $I->see('Gii');
    }

}
