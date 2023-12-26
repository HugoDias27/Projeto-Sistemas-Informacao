<?php


namespace common\tests\Unit;

use common\models\User;
use common\tests\UnitTester;

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

        $user->username = 25;
        $user->auth_key = 25;
        $user->password_hash = 25;
        $user->email = 25;
        $user->status = null;
        $user->created_at = null;
        $user->updated_at = null;

    }

    public function testSavingUser()
    {

        $user = new User();


    }
}
