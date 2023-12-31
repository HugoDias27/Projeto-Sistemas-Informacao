<?php


namespace common\tests\Unit;

use common\models\User;
use common\tests\UnitTester;
use Yii;

class UserTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testValidation()
    {
        $user = new User();

        $user->username = 22;
        $this->assertFalse($user->validate());

        $user->auth_key = 'Texto muito longo para a autenticação';
        $this->assertFalse($user->validate());

        $user->password_hash = 'Uma descrição muito longa que ultrapassa o limite de 255 caracteres no hash da senha';
        $this->assertFalse($user->validate());

        $user->email = 'email@dominio'; // Email inválido sem a extensão do domínio (.com)
        $this->assertFalse($user->validate());

        $user->status = 100;
        $this->assertFalse($user->validate());

        $user->created_at = 'Não é um número';
        $this->assertFalse($user->validate());

        $user->updated_at = 'Outro valor inválido';
        $this->assertFalse($user->validate());
    }


    public function testSavingUser()
    {
        $user = new User();

        $user->username = 'Eduardo Andrade';
        $user->email = 'eduardoandrade@gmail.com';
        $user->setPassword('eduardo.andrade2024');
        $user->generateAuthKey();
        $user->save(false);

        $user->save();
        $this->tester->seeInDatabase('user', ['username' => 'Eduardo Andrade']);
    }
}
