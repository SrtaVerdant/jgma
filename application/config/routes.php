<?php
defined('BASEPATH') or exit('No direct script access allowed');

// ROTAS
$route['default_controller'] = 'funcionarios';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Logout
$route['logout'] = 'funcionarios/logout';
//Recuperar Senha
$route['recuperar-senha'] = 'funcionarios/recuperarSenha';
// Dashboad de ações
$route['dashboard'] = 'dashboard/home';
// Inserir produto
$route['dashboard/inserir'] = 'dashboard/LoadInserir';
// Consultar produto
$route['dashboard/consultar/produtos'] = 'dashboard/LoadConsultar';
$route['dashboard/produtos'] = 'dashboard/dataTableProdutos';
// Relatório dos produtos
$route['dashboard/relatorio'] = 'dashboard/LoadRelatorio';
// Editar produto
$route['dashboard/editar/(:num)'] = 'dashboard/LoadEditar/$1';
// Excluir produto
$route['dashboard/excluir/(:num)'] = 'dashboard/excluirProduto/$1';
// Venda produto
$route['dashboard/venda/(:num)'] = 'dashboard/LoadVendaProduto/$1';
// Consultar vendas
$route['dashboard/consultar/vendas'] = 'dashboard/LoadConsultarVendas';

// Inserir fornecedor
$route['dashboard/fornecedor/inserir'] = 'dashboard/LoadInserirFornecedor';
// Consultar fornecedor
$route['dashboard/fornecedor/consultar'] = 'dashboard/LoadConsultarFornecedor';
$route['dashboard/processing/fornecedores'] = 'dashboard/dataTableFornecedores';
// Editar fornecedor
$route['dashboard/fornecedor/editar/(:num)'] = 'dashboard/LoadEditarFornecedor/$1';

// Inserir item de cozinha(padaria)
$route['dashboard/padaria/inserir'] = 'dashboard/LoadInserirPadaria';
