<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // permissão RBAC dos medicamentos
        $viewMedicamento = $auth->createPermission('viewMedicamento');
        $viewMedicamento->description = 'Ver os medicamentos';
        $auth->add($viewMedicamento);

        $createMedicamento = $auth->createPermission('createMedicamento');
        $createMedicamento->description = 'Criar um medicamento';
        $auth->add($createMedicamento);

        $updateMedicamento = $auth->createPermission('updateMedicamento');
        $updateMedicamento->description = 'Atualizar um medicamento';
        $auth->add($updateMedicamento);

        $deleteMedicamento = $auth->createPermission('deleteMedicamento');
        $deleteMedicamento->description = 'Apagar um medicamento';
        $auth->add($deleteMedicamento);

        // permissão RBAC dos funcionarios
        $viewFuncionario = $auth->createPermission('viewFuncionario');
        $viewFuncionario->description = 'Ver os funcionarios';
        $auth->add($viewFuncionario);

        $createFuncionario = $auth->createPermission('createFuncionario');
        $createFuncionario->description = 'Criar funcionario';
        $auth->add($createFuncionario);

        $updateFuncionario = $auth->createPermission('updateFuncionario');
        $updateFuncionario->description = 'Editar o funcionario';
        $auth->add($updateFuncionario);

        $deleteFuncionario = $auth->createPermission('deleteFuncionario');
        $deleteFuncionario->description = 'Apagar funcionario';
        $auth->add($deleteFuncionario);


        // permissão RBAC dos utentes
        $viewUtente = $auth->createPermission('viewUtente');
        $viewUtente->description = 'Ver os utentes';
        $auth->add($viewUtente);

        $createUtente = $auth->createPermission('createUtente');
        $createUtente->description = 'Criar utente';
        $auth->add($createUtente);

        $updateUtente = $auth->createPermission('updateUtente');
        $updateUtente->description = 'Editar o utente';
        $auth->add($updateUtente);

        $deleteUtente = $auth->createPermission('deleteUtente');
        $deleteUtente->description = 'Apagar o utente';
        $auth->add($deleteUtente);

        // permissão RBAC dos users
        $viewUser = $auth->createPermission('viewUser');
        $viewUser->description = 'Ver os users';
        $auth->add($viewUser);

        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Criar user';
        $auth->add($createUser);

        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'Editar o user';
        $auth->add($updateUser);

        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Apagar o user';
        $auth->add($deleteUser);

        // permissão RBAC das vendas
        $viewVenda = $auth->createPermission('viewVenda');
        $viewVenda->description = 'Ver as compras realizadas';
        $auth->add($viewVenda);

        $createVenda = $auth->createPermission('createVenda');
        $createVenda->description = 'Criar venda';
        $auth->add($createVenda);


        // permissão RBAC dos fornecedores
        $viewFornecedor = $auth->createPermission('viewFornecedor');
        $viewFornecedor->description = 'Ver os fornecedores';
        $auth->add($viewFornecedor);

        $createFornecedor = $auth->createPermission('createFornecedor');
        $createFornecedor->description = 'Criar fornecedor';
        $auth->add($createFornecedor);

        $updateFornecedor = $auth->createPermission('updateFornecedor');
        $updateFornecedor->description = 'Editar o fornecedor';
        $auth->add($updateFornecedor);

        $deleteFornecedor = $auth->createPermission('deleteFornecedor');
        $deleteFornecedor->description = 'Apagar fornecedor';
        $auth->add($deleteFornecedor);

        // permissão RBAC das receitas medicas
        $viewReceita = $auth->createPermission('viewReceita');
        $viewReceita->description = 'Ver as receitas medicas';
        $auth->add($viewReceita);

        $createReceita = $auth->createPermission('createReceita');
        $createReceita->description = 'Criar receita medica';
        $auth->add($createReceita);

        $updateReceita = $auth->createPermission('updateReceita');
        $updateReceita->description = 'Editar a receita medica';
        $auth->add($updateReceita);

        $deleteReceita = $auth->createPermission('deleteReceita');
        $deleteReceita->description = 'Apagar a receita medica';
        $auth->add($deleteReceita);

        // permissão RBAC dos estabelecimentos
        $viewEstabelecimento = $auth->createPermission('viewEstabelecimento');
        $viewEstabelecimento->description = 'Ver os estabelecimentos';
        $auth->add($viewEstabelecimento);

        $createEstabelecimento = $auth->createPermission('createEstabelecimento');
        $createEstabelecimento->description = 'Criar estabelecimento';
        $auth->add($createEstabelecimento);

        $updateEstabelecimento = $auth->createPermission('updateEstabelecimento');
        $updateEstabelecimento->description = 'Editar o estabelecimento';
        $auth->add($updateEstabelecimento);

        $deleteEstabelecimento = $auth->createPermission('deleteEstabelecimento');
        $deleteEstabelecimento->description = 'Apagar o estabelecimento';
        $auth->add($deleteEstabelecimento);


        // permissão RBAC das despesas
        $viewDespesa = $auth->createPermission('viewDespesa');
        $viewDespesa->description = 'Ver as despesas';
        $auth->add($viewDespesa);

        $createDespesa = $auth->createPermission('createDespesa');
        $createDespesa->description = 'Criar despesa';
        $auth->add($createDespesa);

        $updateDespesa = $auth->createPermission('updateDespesa');
        $updateDespesa->description = 'Editar despesa';
        $auth->add($updateDespesa);

        $deleteDespesa = $auth->createPermission('deleteDespesa');
        $deleteDespesa->description = 'Apagar despesa';
        $auth->add($deleteDespesa);


        // permissão RBAC das faturas
        $viewFatura = $auth->createPermission('viewFatura');
        $viewFatura->description = 'Ver fatura';
        $auth->add($viewFatura);

        $createFatura = $auth->createPermission('createFatura');
        $createFatura->description = 'Criar fatura';
        $auth->add($createFatura);

        $deleteFatura = $auth->createPermission('deleteFatura');
        $deleteFatura->description = 'Apagar fatura';
        $auth->add($deleteFatura);

        // permissão RBAC das estatisticas
        $viewEstatisticas = $auth->createPermission('viewEstatisticas');
        $viewEstatisticas->description = 'Ver estatisticas';
        $auth->add($viewEstatisticas);


        // permissão RBAC dos servicos
        $viewServico = $auth->createPermission('viewServico');
        $viewServico->description = 'Ver servicos';
        $auth->add($viewServico);

        $createServico = $auth->createPermission('createServico');
        $createServico->description = 'Criar servico';
        $auth->add($createServico);

        $updateServico = $auth->createPermission('updateServico');
        $updateServico->description = 'Editar servico';
        $auth->add($updateServico);

        $deleteServico = $auth->createPermission('deleteServico');
        $deleteServico->description = 'Apagar servico';
        $auth->add($deleteServico);


        // permissão RBAC do carrinho de compras
        $viewCarrinhoCompras = $auth->createPermission('viewCarrinhoCompras');
        $viewCarrinhoCompras->description = 'Ver Carrinho de Compras';
        $auth->add($viewCarrinhoCompras);

        $createCarrinhoCompras = $auth->createPermission('createCarrinhoCompras');
        $createCarrinhoCompras->description = 'Criar Carrinho de Compras';
        $auth->add($createCarrinhoCompras);

        $updateCarrinhoCompras = $auth->createPermission('updateCarrinhoCompras');
        $updateCarrinhoCompras->description = 'Editar Carrinho de Compras';
        $auth->add($updateCarrinhoCompras);

        $deleteCarrinhoCompras = $auth->createPermission('deleteCarrinhoCompras');
        $deleteCarrinhoCompras->description = 'Apagar Carrinho de Compras';
        $auth->add($deleteCarrinhoCompras);


        // adicionar as permissões ao cliente
        $cliente = $auth->createRole('cliente');
        $auth->add($cliente);
        $auth->addChild($cliente, $viewMedicamento);
        $auth->addChild($cliente, $viewVenda);
        $auth->addChild($cliente, $viewReceita);
        $auth->addChild($cliente, $viewDespesa);
        $auth->addChild($cliente, $viewFatura);
        $auth->addChild($cliente, $viewEstatisticas);
        $auth->addChild($cliente, $viewServico);
        $auth->addChild($cliente, $viewCarrinhoCompras);
        $auth->addChild($cliente, $createCarrinhoCompras);
        $auth->addChild($cliente, $updateCarrinhoCompras);
        $auth->addChild($cliente, $deleteCarrinhoCompras);


        // adicionar as permissões ao funcionario
        $funcionario = $auth->createRole('funcionario');
        $auth->add($funcionario);
        $auth->addChild($funcionario, $createMedicamento);
        $auth->addChild($funcionario, $updateMedicamento);
        $auth->addChild($funcionario, $deleteMedicamento);
        $auth->addChild($funcionario, $viewUtente);
        $auth->addChild($funcionario, $createUtente);
        $auth->addChild($funcionario, $updateUtente);
        $auth->addChild($funcionario, $createVenda);
        $auth->addChild($funcionario, $viewFornecedor);
        $auth->addChild($funcionario, $createReceita);
        $auth->addChild($funcionario, $updateReceita);
        $auth->addChild($funcionario, $viewEstabelecimento);
        $auth->addChild($funcionario, $createDespesa);
        $auth->addChild($funcionario, $updateDespesa);
        $auth->addChild($funcionario, $deleteDespesa);
        $auth->addChild($funcionario, $createFatura);
        $auth->addChild($funcionario, $createServico);
        $auth->addChild($funcionario, $updateServico);
        $auth->addChild($funcionario, $cliente);

        // adicionar as permissões ao admin
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $viewFuncionario);
        $auth->addChild($admin, $createFuncionario);
        $auth->addChild($admin, $updateFuncionario);
        $auth->addChild($admin, $deleteFuncionario);
        $auth->addChild($admin, $deleteUtente);
        $auth->addChild($admin, $createFornecedor);
        $auth->addChild($admin, $updateFornecedor);
        $auth->addChild($admin, $deleteFornecedor);
        $auth->addChild($admin, $viewUser);
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $updateUser);
        $auth->addChild($admin, $deleteUser);
        $auth->addChild($admin, $deleteReceita);
        $auth->addChild($admin, $createEstabelecimento);
        $auth->addChild($admin, $updateEstabelecimento);
        $auth->addChild($admin, $deleteEstabelecimento);
        $auth->addChild($admin, $deleteDespesa);
        $auth->addChild($admin, $deleteFatura);
        $auth->addChild($admin, $deleteServico);
        $auth->addChild($admin, $funcionario);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($cliente, 3);
        $auth->assign($funcionario, 2);
        $auth->assign($admin, 1);
    }
}
