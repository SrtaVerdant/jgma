<?php

use function PHPSTORM_META\type;

defined('BASEPATH') or exit('No direct script access allowed');
require './vendor/autoload.php';

class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('dashboard_model');
	}

	public function validaCargo($rota)
	{

		$cargo = (int)$this->session->userdata('cargo');
		switch ($rota) {
			case 'relatorio':
				if ($cargo > 1) {
					$this->session->set_userdata('permissao', 'erro');
					$this->session->set_userdata('msg', 'Você não tem permissão para acessar relatórios');
					redirect('dashboard');
				}
				break;

			case 'padaria':
				if ($cargo > 2 && $cargo != 6) {
					$this->session->set_userdata('permissao', 'erro');
					$this->session->set_userdata('msg', 'Você não tem permissão para acessar padaria');
					redirect('dashboard');
				}
				break;

			case 'inserir-produto':
				if ($cargo > 4) {
					$this->session->set_userdata('permissao', 'erro');
					$this->session->set_userdata('msg', 'Você não tem permissão para adicionar produtos!');
					redirect('dashboard');
				}
				break;

			case 'editar-produto-padaria':
				if ($cargo > 3 && $cargo != 6) {
					$this->session->set_userdata('permissao', 'erro');
					$this->session->set_userdata('msg', 'Você não tem permissão para editar este produto!');
					redirect('dashboard/consultar/produtos');
				}
				break;

				case 'editar-produto':
					if ($cargo > 3) {
						$this->session->set_userdata('permissao', 'erro');
						$this->session->set_userdata('msg', 'Você não tem permissão para editar este produto!');
						redirect('dashboard/consultar/produtos');
					}
					break;

			case 'excluir-produto':
				if ($cargo > 2) {
					$this->session->set_userdata('permissao', 'erro');
					$this->session->set_userdata('msg', 'Você não tem permissão para excluir produtos!');
					redirect('dashboard/consultar/produtos');
				}
				break;

			case 'venda-produto':
				if ($cargo > 2 && ($cargo != 4 || $cargo != 5)) {
					$this->session->set_userdata('permissao', 'erro');
					$this->session->set_userdata('msg', 'Você não tem permissão para vender produtos!');
					redirect('dashboard/consultar/produtos');
				}
				break;

			case 'inserir-fornecedor':
				if ($cargo > 3) {
					$this->session->set_userdata('permissao', 'erro');
					$this->session->set_userdata('msg', 'Você não tem permissão para adicionar fornecedor!');
					redirect('dashboard');
				}
				break;

			case 'consultar-fornecedor':
				if ($cargo > 4) {
					$this->session->set_userdata('permissao', 'erro');
					$this->session->set_userdata('msg', 'Você não tem permissão para consultar fornecedores!');
					redirect('dashboard');
				}
				break;

			case 'editar-fornecedor':
				if ($cargo > 3) {
					$this->session->set_userdata('permissao', 'erro');
					$this->session->set_userdata('msg', 'Você não tem permissão para editar fornecedores!');
					redirect('dashboard');
				}
				break;

				case 'relatorio-vendas':
					if ($cargo > 1) {
						$this->session->set_userdata('permissao', 'erro');
						$this->session->set_userdata('msg', 'Você não tem permissão para consultar o relatório de vendas');
						redirect('dashboard');
					}
					break;

					case 'relatorio-produtos':
						if ($cargo > 1) {
							$this->session->set_userdata('permissao', 'erro');
							$this->session->set_userdata('msg', 'Você não tem permissão para consultar o relatório de produtos');
							redirect('dashboard');
						}
						break;

			default:
				# code...
				break;
		}
	}

	public function home()
	{

		$dados['titulo'] = 'Dashboard';

		if ($this->session->userdata('login') == 'ok') {
			$this->load->view('dashboard/dashboard', $dados);
		} else {
			redirect('');
		}
	}

	public function LoadInserir()
	{
		$this->validaCargo('inserir-produto');
		if ($this->session->userdata('login') == 'ok') {

			$dados['titulo'] = 'Inserir produto';
			$dados['fornecedores'] = $this->dashboard_model->getAllFornecedores();
			$dados['tiposProdutos'] = $this->dashboard_model->getAllTipoProdutos();

			$this->load->view('crud/inserir', $dados);
		} else {
			redirect('');
		}
	}

	public function inserirProduto()
	{
		$this->session->set_userdata('inserir', '');

		$produto = array(
			'funcional' =>	(int)$this->session->userdata('funcional'),
			'nome' => $this->input->post('produto'),
			'qtd' => (int)$this->input->post('quantidade'),
			'fk_fornecedor' => (int)$this->input->post('fornecedor'),
			'fk_tipo' => (int)$this->input->post('tipo'),
			'data_validade' => $this->input->post('validade'),
			'data_compra' => $this->input->post('datacompra'),
			'preco_unitario' => formataMoedaDecimal($this->input->post('preco')),
			'qtdmin' => (int)$this->input->post('qtdmin'),
			'qtdmax' => (int)$this->input->post('qtdmax')
		);

		if ($produto['fk_fornecedor'] == '-' || $produto['preco_unitario'] == 0.00 || empty(trim($produto['qtd'])) || empty(trim($produto['qtdmin'])) || empty(trim($produto['qtdmax']))) {
			$this->session->set_userdata('inserir', 'erro');
		} else {
			$this->dashboard_model->cadastraProduto($produto);
			$this->session->set_userdata('inserir', 'ok');
		}

		redirect('dashboard');
	}

	public function LoadConsultar()
	{
		if ($this->session->userdata('login') == 'ok') {

			$dados['titulo'] = 'Consultar produtos';
			$dados['produtos'] = $this->dashboard_model->getAllProdutosExcetoPadaria();

			$this->session->set_userdata('id_prod', '');
			$this->session->set_userdata('id_fornecedor', '');

			$this->load->view('crud/consultar', $dados);
		} else {
			redirect('');
		}
	}

	public function LoadRelatorio()
	{
		$this->validaCargo('relatorio');
		if ($this->session->userdata('login') == 'ok') {

			$dados['titulo'] = 'Relatório';
			$dados['produtos'] = $this->dashboard_model->getAllProdutosExcetoPadaria();
			$dados['padaria'] = $this->dashboard_model->getAllProdutosPadaria();
			$dados['vendas'] = $this->dashboard_model->getAllVendas();

			$mes = date("m");
			$ano = date("Y");
			$dia = date("d");

			$dados['vendamensal'] = [];
			$dados['vendadiaria'] = [];
			$dados['vendaanual'] = [];
			if ($dados['vendas']) {
				foreach ($dados['vendas'] as $venda) {
					$mensal = explode(' ', $venda->date_inserted);
					$mensal = explode('-', $venda->date_inserted);

					if ($mensal[1] == $mes && $mensal[0] == $ano) {
						array_push($dados['vendamensal'], $venda);
					}

					$diario = explode(' ', $mensal[2]);
					if ($mensal[1] == $mes && $mensal[0] == $ano && $mensal[0] == $ano && $diario[0] == $dia) {
						array_push($dados['vendadiaria'], $venda);
					}

					if ($mensal[0] == $ano) {
						array_push($dados['vendaanual'], $venda);
					}
				}
			}

			$dados['qtdproduto'] = [];
			if ($dados['produtos']) {
				foreach ($dados['produtos'] as $produto) {
					$mensal = explode('/', $produto->prazo_validade);
					if ($mensal[1] == $mes && $mensal[2] == $ano) {
						array_push($dados['qtdproduto'], $produto);
					}
				}
			}



			$this->session->set_userdata('id_prod', '');
			$this->session->set_userdata('id_fornecedor', '');

			$this->load->view('relatorio/relatorio', $dados);
		} else {
			redirect('');
		}
	}

	public function LoadEditar($id)
	{
		
		if ($this->session->userdata('login') == 'ok') {

			$dados['produto'] = $this->dashboard_model->getProdutoById($id);
			$this->session->set_userdata('id_prod', $id);

			if ($dados['produto']->fk_prod_tipo == 15) {
				$this->validaCargo('editar-produto-padaria');
				$dados['titulo'] = 'Editar item padaria';

				$this->load->view('crud-padaria/editar', $dados);
			} else {
				$this->validaCargo('editar-produto');
				$dados['titulo'] = 'Editar produto';
				$dados['fornecedores'] = $this->dashboard_model->getAllFornecedores();
				$dados['tiposProdutos'] = $this->dashboard_model->getAllTipoProdutos();
				$this->load->view('crud/editar', $dados);
			}
		} else {
			redirect('');
		}
	}

	public function editarProduto()
	{
		$this->session->set_userdata('editar', '');

		$produto = array(
			'id' =>	(int)$this->session->userdata('id_prod'),
			'funcional' =>	(int)$this->session->userdata('funcional'),
			'nome' => $this->input->post('produto'),
			'qtd' => (int)$this->input->post('quantidade'),
			'fk_fornecedor' => (int)$this->input->post('fornecedor'),
			'fk_tipo' => (int)$this->input->post('tipo'),
			'data_validade' => $this->input->post('validade'),
			'data_compra' => $this->input->post('datacompra'),
			'preco_unitario' => formataMoedaDecimal($this->input->post('preco')),
			'qtdmin' => (int)$this->input->post('qtdmin'),
			'qtdmax' => (int)$this->input->post('qtdmax')
		);

		if ($produto['fk_fornecedor'] == '-' || $produto['preco_unitario'] == 0.00 || empty(trim($produto['qtd'])) || empty(trim($produto['qtdmin'])) || empty(trim($produto['qtdmax']))) {
			$this->session->set_userdata('editar', 'erro');
		} else {
			$this->dashboard_model->editaProduto($produto);
			$this->session->set_userdata('editar', 'ok');
		}

		redirect('dashboard/consultar/produtos');
	}

	public function dataTableProdutos()
	{
		$table = 'vw_produtos';

		$primaryKey = 'id_prod_pk';

		$columns = array(
			array('db' => 'id_prod_pk', 'dt' => 0),
			array(
				'db' => 'nome',
				'dt' => 1,
				'formatter' => function ($d) {
					return strtoupper(retiraCaracteresEspeciais($d));
				}
			),
			array('db' => 'nome_forne',  'dt' => 2),
			array(
				'db'        => 'valor_unitario',
				'dt'        => 3,
				'formatter' => function ($d, $row) {
					return 'R$ ' . number_format($d, 2, ",", ".");
				}
			),
			array('db' => 'desc_tipo',     'dt' => 4),
			array('db' => 'quantidade',     'dt' => 5),
			array('db' => 'prazo_validade',     'dt' => 6),
			array('db' => 'data_compra',     'dt' => 7),
			array(
				'db'        => 'id_prod_pk',
				'dt'        => 8,
				'formatter' => function ($d) {
					return "<div class='row'><div class='col-md-4'><a href='" . base_url('dashboard/editar/') . $d . " 'target=''><i class='fa fa-pencil' aria-hidden='true'></i></a></div>
					
					<div class='col-md-4'><a class='' href='" . base_url('dashboard/excluir/') . $d . " 'target=''><i class='fa fa-trash-o' aria-hidden='true'></i></a></div>
					
					<div class='col-md-4'><a class='' href='" . base_url('dashboard/venda/') . $d . " 'target=''><i class='fa fa-usd' aria-hidden='true'></i></a></div></div>";
				}
			)
		);

		$sql_details = array(
			'user' => 'nexuco44_adminjgma',
			'pass' => 'jgma!7070',
			'db'   => 'nexuco44_grupo-jgma',
			'host' => '108.179.193.193'
		);

		require('./application/libraries/ssp.class.php');

		echo json_encode(
			SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
		);
	}

	public function excluirProduto($id)
	{
		$this->validaCargo('excluir-produto');
		$this->dashboard_model->excluiProduto((int)$id);
		$this->session->set_userdata('excluir', 'ok');

		redirect('dashboard/consultar/produtos');
	}

	public function LoadVendaProduto($id_produto)
	{
		$this->validaCargo('venda-produto');
		if ($this->session->userdata('login') == 'ok') {

			$dados['titulo'] = 'Venda produto';
			$dados['produto'] = $this->dashboard_model->getProdutoById($id_produto);

			$this->session->set_userdata('id_prod', $id_produto);
			$this->load->view('crud/venda', $dados);
		} else {
			redirect('');
		}
	}

	public function inserirVenda()
	{
		$produto = $this->dashboard_model->getProdutoById($this->session->userdata('id_prod'));
		$qtdvendas = (int)$this->input->post('qtdvendas');
		$qtdproduto = (int)$produto->quantidade;

		$venda = array(
			'nome' => $produto->nome,
			'qtd' => $qtdvendas,
			'valor' => $produto->valor_unitario,
			'funcional' => $this->session->userdata('funcional')

		);

		$this->dashboard_model->registraVenda($venda);
		$venda = $qtdproduto - $qtdvendas;
		if ($venda == 0) {
			$this->dashboard_model->excluiProduto($this->session->userdata('id_prod'));
		} else {
			$this->dashboard_model->atualizaQtdProduto($this->session->userdata('id_prod'), $venda);
		}

		$this->session->set_userdata('venda', 'ok');

		redirect('dashboard');
	}

	public function LoadConsultarVendas()
	{	
		$this->validaCargo('relatorio-vendas');
		if ($this->session->userdata('login') == 'ok') {

			$dados['titulo'] = 'Consultar vendas';

			$this->load->view('relatorio/vendas', $dados);
		} else {
			redirect('');
		}
	}

	public function dataTableVendas()
	{
		$table = 'vw_vendas';

		$primaryKey = 'id_venda';

		$columns = array(
			array(
				'db' => 'nome',
				'dt' => 0,
				'formatter' => function ($d) {
					return strtoupper(retiraCaracteresEspeciais($d));
				}
			),
			array('db' => 'quantidade',     'dt' => 1),
			array(
				'db'        => 'valor_unitario',
				'dt'        => 2,
				'formatter' => function ($d) {
					return 'R$ ' . number_format($d, 2, ",", ".");
				}
			),
			array('db' => 'nome_funcionario',     'dt' => 3),
			array(
				'db' => 'data_compra',
				'dt' => 4,
				'formatter' => function ($d) {
					$datahora = explode(' ', $d);
					$data = explode('-', $datahora[0]);
					$hora = explode(':', $datahora[1]);
					return $data[2] . '/' . $data[1] . '/' . $data[0] . ' - ' . $hora[0] . ':' . $hora[1];
				}
			)

		);

		$sql_details = array(
			'user' => 'nexuco44_adminjgma',
			'pass' => 'jgma!7070',
			'db'   => 'nexuco44_grupo-jgma',
			'host' => '108.179.193.193'
		);

		require('./application/libraries/ssp.class.php');

		echo json_encode(
			SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
		);
	}

	public function LoadRelatorioProdutos()
	{
		$this->validaCargo('relatorio-produtos');
		if ($this->session->userdata('login') == 'ok') {

			$dados['titulo'] = 'Relatório geral de produtos';

			$this->load->view('relatorio/produtos', $dados);
		} else {
			redirect('');
		}
	}

	public function dataTableRelatorioProdutos()
	{
		$table = 'vw_produtos';

		$primaryKey = 'id_prod_pk';

		$columns = array(
			array('db' => 'id_prod_pk', 'dt' => 0),
			array(
				'db' => 'nome',
				'dt' => 1,
				'formatter' => function ($d) {
					return strtoupper(retiraCaracteresEspeciais($d));
				}
			),
			array('db' => 'nome_forne',  'dt' => 2),
			array(
				'db'        => 'valor_unitario',
				'dt'        => 3,
				'formatter' => function ($d, $row) {
					return 'R$ ' . number_format($d, 2, ",", ".");
				}
			),
			array('db' => 'desc_tipo',     'dt' => 4),
			array('db' => 'quantidade',     'dt' => 5),
			array('db' => 'prazo_validade',     'dt' => 6),
			array('db' => 'data_compra',     'dt' => 7),
			array('db' => 'qtd_min',     'dt' => 8),
			array('db' => 'qtd_max',     'dt' => 9)

		);

		$sql_details = array(
			'user' => 'nexuco44_adminjgma',
			'pass' => 'jgma!7070',
			'db'   => 'nexuco44_grupo-jgma',
			'host' => '108.179.193.193'
		);

		require('./application/libraries/ssp.class.php');

		echo json_encode(
			SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
		);
	}

	public function LoadInserirPadaria()
	{
		$this->validaCargo('padaria');
		if ($this->session->userdata('login') == 'ok') {

			$dados['titulo'] = 'Inserir item de padaria';

			$this->load->view('crud-padaria/inserir', $dados);
		} else {
			redirect('');
		}
	}

	public function inserirProdutoPadaria()
	{
		$this->session->set_userdata('inserir', '');

		$padaria = array(
			'funcional' => (int)$this->session->userdata('funcional'),
			'nome' => $this->input->post('produto'),
			'qtd' => (int)$this->input->post('quantidade'),
			'fk_fornecedor' => 48,
			'fk_tipo' => 15,
			'data_validade' => $this->input->post('validade'),
			'preco_unitario' => formataMoedaDecimal($this->input->post('preco'))
		);

		if ($padaria['preco_unitario'] == 0.00 || empty(trim($padaria['qtd']))) {
			$this->session->set_userdata('inserir', 'erro');
		} else {
			$this->dashboard_model->cadastraItemPadaria($padaria);
			$this->session->set_userdata('inserir', 'ok');
		}

		redirect('dashboard');
	}

	public function editarProdutoPadaria()
	{
		$this->session->set_userdata('editar', '');

		$padaria = array(
			'funcional' => (int)$this->session->userdata('funcional'),
			'id_produto' => (int)$this->session->userdata('id_prod'),
			'nome' => $this->input->post('produto'),
			'qtd' => (int)$this->input->post('quantidade'),
			'fk_fornecedor' => 48,
			'fk_tipo' => 15,
			'data_validade' => $this->input->post('validade'),
			'preco_unitario' => formataMoedaDecimal($this->input->post('preco'))
		);

		if ($padaria['preco_unitario'] == 0.00 || empty(trim($padaria['qtd']))) {
			$this->session->set_userdata('editar', 'erro');
		} else {
			$this->dashboard_model->editaItemPadaria($padaria);
			$this->session->set_userdata('editar', 'ok');
		}

		redirect('dashboard/consultar/produtos');
	}

	public function LoadInserirFornecedor()
	{
		$this->validaCargo('inserir-fornecedor');
		if ($this->session->userdata('login') == 'ok') {

			$dados['titulo'] = 'Inserir fornecedor';
			$dados['fornecedores'] = $this->dashboard_model->getAllFornecedores();

			$this->load->view('crud-fornecedor/inserir', $dados);
		} else {
			redirect('');
		}
	}

	public function inserirFornecedor()
	{
		$this->session->set_userdata('inserir_fornecedor', '');

		$fornecedor = array(
			'nome' => strtoupper(retiraCaracteresEspeciais($this->input->post('fornecedor'))),
			'cnpj' => $this->input->post('cnpj')
		);

		if (empty(trim($fornecedor['nome']))) {
			$this->session->set_userdata('inserir_fornecedor', 'erro');
		} else {
			if ($this->dashboard_model->cadastraFornecedor($fornecedor)) {
				$this->session->set_userdata('inserir_fornecedor', 'ok');
			} else {
				$this->session->set_userdata('inserir_fornecedor', 'erro');
			}
		}
		redirect('dashboard');
	}

	public function LoadConsultarFornecedor()
	{
		$this->validaCargo('consultar-fornecedor');
		if ($this->session->userdata('login') == 'ok') {

			$dados['titulo'] = 'Consultar fornecedores';
			$dados['produtos'] = $this->dashboard_model->getAllProdutos();

			$this->session->set_userdata('id_prod', '');
			$this->load->view('crud-fornecedor/consultar', $dados);
		} else {
			redirect('');
		}
	}

	public function dataTableFornecedores()
	{
		$table = 'fornecedores';

		$primaryKey = 'id_forne_pk';

		$columns = array(
			array(
				'db' => 'nome_forne',
				'dt' => 0,
				'formatter' => function ($d) {
					return strtoupper(retiraCaracteresEspeciais($d));
				}
			),
			array('db' => 'cnpj',  'dt' => 1),
			array(
				'db'        => 'id_forne_pk',
				'dt'        => 2,
				'formatter' => function ($d) {
					return "<a href='" . base_url('dashboard/fornecedor/editar/') . $d . " 'target=''><i class='fa fa-pencil' aria-hidden='true'></i></a></div>";
				}
			)
		);

		$sql_details = array(
			'user' => 'nexuco44_adminjgma',
			'pass' => 'jgma!7070',
			'db'   => 'nexuco44_grupo-jgma',
			'host' => '108.179.193.193'
		);

		require('./application/libraries/ssp.class.php');

		echo json_encode(
			SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
		);
	}

	public function LoadEditarFornecedor($id_fornecedor)
	{
		$this->validaCargo('editar-fornecedor');
		if ($this->session->userdata('login') == 'ok') {

			$dados['titulo'] = 'Editar fornecedor';
			$dados['fornecedor'] = $this->dashboard_model->getFornecedorById($id_fornecedor);

			$this->session->set_userdata('id_fornecedor', $id_fornecedor);
			$this->load->view('crud-fornecedor/editar', $dados);
		} else {
			redirect('');
		}
	}

	public function editarFornecedor()
	{
		$this->session->set_userdata('editar_fornecedor', '');

		$fornecedor = array(
			'id_fornecedor' => (int) $this->session->userdata('id_fornecedor'),
			'nome' => strtoupper(retiraCaracteresEspeciais($this->input->post('fornecedor'))),
			'cnpj' => $this->input->post('cnpj')
		);

		if (empty(trim($fornecedor['nome']))) {
			$this->session->set_userdata('editar_fornecedor', 'erro');
		} else {
			$this->dashboard_model->editarFornecedor($fornecedor);
			$this->session->set_userdata('editar_fornecedor', 'ok');
		}
		redirect('dashboard/fornecedor/consultar');
	}
}
