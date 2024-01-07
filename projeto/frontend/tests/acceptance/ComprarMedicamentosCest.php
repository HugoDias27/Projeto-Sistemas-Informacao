<?php


namespace frontend\tests\Acceptance;

use Codeception\Util\Locator;
use frontend\tests\AcceptanceTester;

class ComprarMedicamentosCest
{
    // Teste para realizar uma compra de produtos com e sem receita médica
    public function TestarCompraMedicamentos(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Signup');
        $I->wait(2);
        $I->click('Signup');
        $I->see('Signup');
        $I->wait(2);

        $I->fillField('#username', 'GabrielBolas');
        $I->fillField('#email','BolasGaming@gmail.com');
        $I->fillField('#password', 'bolasgaming2023');
        $I->wait(2);
        $I->click('signup-button');
        $I->wait(2);
        $I->see('Login');
        $I->click('Login');
        $I->see('Login');
        $I->wait(2);
        $I->fillField('#username', 'GabrielBolas');
        $I->fillField('#password', 'bolasgaming2023');
        $I->click('login-button');
        $I->wait(2);
        $I->see('Logout (GabrielBolas)');
        $I->click(Locator::find('i', ['title' => 'menu-cliente']));
        $I->wait(2);
        $I->see('Definições do perfil');
        $I->click('Definições do perfil');
        $I->wait(2);
        $I->see('Create Profile');
        $I->fillField('N Utente', '123456789');
        $I->fillField('Nif', '264444414');
        $I->fillField('Morada', 'Rua do Caroulo');
        $I->fillField('Telefone', '912345678');
        $I->wait(2);
        $I->click('Save');
        $I->wait(2);
        $I->see('GabrielBolas');
        $I->click('Página Inicial');
        $I->wait(2);

        $I->see('Brufens');
        $I->click(Locator::find('a', ['href' => 'produto/detalhes?id=1']));
        $I->wait(3);
        $I->see('Informações Técnicas');
        $I->click('Adicionar ao Carrinho');
        $I->wait(3);
        $I->fillField('ReceitaMedica[codigo]', '4789');
        $I->see('Verificar');
        $I->click('Verificar');
        $I->wait(3);
        $I->click('Carrinho');
        $I->wait(3);
        $I->see('Carrinho Compras');
        $I->fillField('quantidade', '2');
        $I->click('Atualizar');
        $I->wait(2);

        $I->click('Página Inicial');
        $I->wait(2);
        $I->see('Ben-U-Ron');
        $I->click('Ben-U-Ron');
        $I->wait(3);
        $I->see('Informações Técnicas');
        $I->wait(2);
        $I->click('Adicionar ao Carrinho');
        $I->wait(3);
        $I->see('Carrinho');
        $I->click('Carrinho');
        $I->wait(1);
        $I->see('Carrinho Compras');
        $I->seeInField('quantidade', '1');
        $I->fillField('quantidade', '3');
        $I->wait(1);
        $I->click('Concluir Carrinho');
        $I->see('Dados de Entrega');
        $I->wait(1);
        $I->click('Multibanco');
        $I->wait(3);
        $I->click('Concluir Compra');
        $I->wait(2);
        $I->see('Logout (GabrielBolas)');
    }
}
