<?php


namespace backend\tests\Functional;

use backend\tests\FunctionalTester;

class CreateClienteBackendCest
{
    // Teste de inicialização antes de começar os testes
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('/');
        $I->see('Sign in to start your session', 'p');
        $I->fillField('#username', 'admin');
        $I->fillField('#password', 'admin*2024');
        $I->click('Sign In');
        $I->see('Bem vindo, admin');
        $I->click('Registo de utilizadores');
    }

    // Teste para criar um novo utilizador(cliente) através da página de criação de utilizadores do backend
    public function CreateClienteBackend(FunctionalTester $I)
    {
        $I->see('Criar Utilizador');
        $I->click('Criar Utilizador');
        $I->see('Criar utilizador');
        $I->see('Carolo Farmacêutica');
        $I->fillField('Username', 'Ricardo Miranda');
        $I->fillField('Password', 'ricardo.miranda2023');
        $I->fillField('Email', 'ricardo@carolo.pt');
        $I->fillField('N Utente', '123456789');
        $I->fillField('Nif', '286445522');
        $I->fillField('Morada', 'Rua da Carolo');
        $I->fillField('Telefone', '912345678');
        $I->selectOption('User[role]', 'cliente');
        $I->click('Save');
        $I->see('Ricardo Miranda');
    }

    // Teste para criar um novo utilizador(funcionário) através da página de criação de utilizadores do backend
    public function CreateFuncionarioBackend(FunctionalTester $I)
    {
        $I->see('Criar Utilizador');
        $I->click('Criar Utilizador');
        $I->see('Criar utilizador');
        $I->see('Carolo Farmacêutica');
        $I->fillField('Username', 'Anthony Sousa');
        $I->fillField('Password', 'Anthony.sousa2023');
        $I->fillField('Email', 'anthony@carolo.pt');
        $I->fillField('N Utente', '656565323');
        $I->fillField('Nif', '212252222');
        $I->fillField('Morada', 'Rua da Carolo');
        $I->fillField('Telefone', '912345999');
        $I->selectOption('User[role]', 'funcionario');
        $I->click('Save');
        $I->see('Anthony Sousa');
    }

    // Teste para criar um novo utilizador(administrador) através da página de criação de utilizadores do backend
    public function CreateAdminBackend(FunctionalTester $I)
    {
        $I->see('Criar Utilizador');
        $I->click('Criar Utilizador');
        $I->see('Criar utilizador');
        $I->see('Carolo Farmacêutica');
        $I->fillField('Username', 'André Oliveira');
        $I->fillField('Password', 'andre.oliveira2023');
        $I->fillField('Email', 'piruka@carolo.pt');
        $I->fillField('N Utente', '654861323');
        $I->fillField('Nif', '282252412');
        $I->fillField('Morada', 'Rua da Carolo');
        $I->fillField('Telefone', '912345419');
        $I->selectOption('User[role]', 'admin');
        $I->click('Save');
        $I->see('André Oliveira');
    }

    // Teste para verificar a condição quando os campos de criação do utilizador ficam vazios
    public function CreateUserSemDados(FunctionalTester $I)
    {
        $I->see('Criar Utilizador');
        $I->click('Criar Utilizador');
        $I->see('Criar utilizador');
        $I->see('Carolo Farmacêutica');
        $I->click('Save');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
        $I->see('Email cannot be blank.');

    }
}