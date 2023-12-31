<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

/* @var $scenario \Codeception\Scenario */

class ContactCest
{
    public function checkContact(FunctionalTester $I)
    {
        $I->amOnRoute('site/contact');
        $I->see('Contactos');
    }
}
