<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class HomeCest
{
    public function checkOpen(FunctionalTester $I)
    {
        $I->amOnRoute(\Yii::$app->homeUrl);
        $I->see('Página Inicial');
        $I->seeLink('Sobre');
        $I->click('Sobre');
        $I->see('Sobre');
    }
}