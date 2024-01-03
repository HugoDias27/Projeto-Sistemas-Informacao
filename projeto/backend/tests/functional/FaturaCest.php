<?php


namespace backend\tests\Functional;


use backend\tests\FunctionalTester;
use common\models\Fatura;
use common\models\User;


class FaturaCest
{


    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('/');
        $I->see('Sign in to start your session', 'p');
        $I->fillField('#username', 'admin');
        $I->fillField('#password', 'admin*2024');
        $I->click('Sign In');
        $I->see('Bem vindo, admin');
        $I->click('Gestão de dados');
        $I->see('Gerir faturas');
        $I->click('Gerir faturas');

    }

    // tests
    public function CriarFaturaTest(FunctionalTester $I)
    {

        $I->see('Criar fatura');
        $I->click('Criar fatura');
        $I->selectOption('Fatura[cliente_id]', '3');
        $I->selectOption('Fatura[estabelecimento_id]', '2');
        $I->click('Guardar');
        $I->fillField('LinhaFatura[quantidade]', '2');
        $I->selectOption('LinhaFatura[servico_id]', '1');
        $I->click('Adicionar servico');
        $I->click('Criar Linha');
        $I->selectOption('LinhaFatura[receita_medica_id]', '1');
        $I->click('Adicionar receita');
        $I->fillField('quantidade', '3');
        $I->click('Atualizar Quantidade');
        $I->click('Criar Linha');
        $I->fillField('LinhaFatura[quantidade]', '2');
        $I->selectOption('LinhaFatura[servico_id]', '1');
        $I->click('Adicionar servico');
        $I->click('Eliminar');
        $I->click('Concluir Fatura');
        $I->see('Faturas');
    }
}
