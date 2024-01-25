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
        $I->click('Logout (GabrielBolas)');
        $I->wait(2);
        $I->click('Login');
        $I->wait(2);
        $I->see('Backend');
        $I->click('Backend');
        $I->wait(2);
        $I->see('Sign in to start your session');
        $I->fillField('#username', 'admin');
        $I->fillField('#password', 'admin*2024');
        $I->click('Sign In');
        $I->wait(2);
        $I->see('Bem vindo, admin');
        $I->click('Gestão de dados');
        $I->wait(2);
        $I->click('Gerir receitas médicas');
        $I->wait(2);
        $I->see('Receitas Médicas');
        $I->click('Criar Receita Médica');
        $I->wait(2);
        $I->selectOption('ReceitaMedica[user_id]', '4');
        $I->wait(1);
        $I->fillField('Codigo', '9494');
        $I->wait(1);
        $I->fillField('Local Prescricao', 'Leiria');
        $I->wait(1);
        $I->fillField('Medico Prescricao', 'Pedro Francisco');
        $I->wait(1);
        $I->fillField('Dosagem', '2');
        $I->wait(1);
        $I->fillField('Data Validade', '05/05/2025');
        $I->wait(1);
        $I->fillField('Telefone', '923333222');
        $I->wait(1);
        $I->SelectOption('Valido', '1');
        $I->wait(1);
        $I->SelectOption('Posologia', '3');
        $I->wait(3);
        $I->click('Guardar');
        $I->wait(2);
        $I->click('Logout');
        $I->wait(2);
        $I->click('Frontend');

        $I->see('Login');
        $I->wait(2);
        $I->fillField('#username', 'GabrielBolas');
        $I->fillField('#password', 'bolasgaming2023');
        $I->click('login-button');
        $I->wait(2);
        $I->see('Logout (GabrielBolas)');
        $I->see('Ben-U-Ron, 500 mg x 20 comp');
        $I->amOnPage('/produto/detalhes?id=1');
     // $I->click('Ben-U-Ron, 500 mg x 20 comp');
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
        $I->wait(3);
        $I->click('Atualizar');
        $I->wait(2);
        $I->click('Página Inicial');
        $I->wait(2);
        $I->see('Brufen Sem Açúcar, 20 mg/mL-200mL');
        $I->amOnPage('/produto/detalhes?id=3');
       // $I->click('Brufen Sem Açúcar, 20 mg/mL-200mL');
        $I->wait(3);
        $I->see('Informações Técnicas');
        $I->click('Adicionar ao Carrinho');
        $I->wait(3);
        $I->fillField('ReceitaMedica[codigo]', '9494');
        $I->click('Verificar');
        $I->wait(2);
        $I->see('Carrinho Compras');
        $I->wait(2);
        $I->click('Concluir Carrinho');
        $I->see('Dados de Entrega');
        $I->wait(2);
        $I->click('Multibanco');
        $I->wait(3);
        $I->click('Concluir Compra');
        $I->wait(2);
        $I->see('Logout (GabrielBolas)');
    }
}