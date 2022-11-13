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

		if ($this->session->userdata('login') == 'ok') {

			$dados['titulo'] = 'Inserir produto';
			$dados['fornecedores'] = $this->dashboard_model->getAllFornecedores();

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
			// 'fk_tipo' => (int)$this->input->post('tipo'),
			'data_validade' => $this->input->post('validade'),
			'fk_tipo' => $this->input->post('tipo'),
			'data_compra' => $this->input->post('datacompra'),
			'preco_unitario' => formataMoedaDecimal($this->input->post('preco'))
		);

		if ($produto['fk_fornecedor'] == '-' || $produto['preco_unitario'] == 0.00 || empty(trim($produto['qtd']))) {
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
			$dados['produtos'] = $this->dashboard_model->getAllProdutos();

			$this->session->set_userdata('id_prod', '');
			$this->load->view('crud/consultar', $dados);
		} else {
			redirect('');
		}
	}

	public function LoadRelatorio()
	{
		echo "em construção 3";
	}

	public function LoadEditar($id)
	{
		if ($this->session->userdata('login') == 'ok') {

			$dados['titulo'] = 'Editar produto';
			$dados['fornecedores'] = $this->dashboard_model->getAllFornecedores();
			$dados['produto'] = $this->dashboard_model->getProdutoById($id);

			//Pegar o parametro que vem de "Consulta Produto"
			$this->session->set_userdata('id_prod', $id);
			$this->load->view('crud/editar', $dados);
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
			// 'fk_tipo' => (int)$this->input->post('tipo'),
			'data_validade' => $this->input->post('validade'),
			'fk_tipo' => $this->input->post('tipo'),
			'data_compra' => $this->input->post('datacompra'),
			'preco_unitario' => formataMoedaDecimal($this->input->post('preco'))
		);

		if ($produto['fk_fornecedor'] == '-' || $produto['preco_unitario'] == 0.00 || empty(trim($produto['qtd']))) {
			$this->session->set_userdata('editar', 'erro');
		} else {
			$this->dashboard_model->editaProduto($produto);
			$this->session->set_userdata('editar', 'ok');
		}

		redirect('dashboard/consultar/produtos');
	}

	public function dataTableProdutos()
	{
		$table = 'produtos';

		$primaryKey = 'id_prod_pk';

		$columns = array(
			array('db' => 'id_prod_pk', 'dt' => 0),
			array('db' => 'nome', 'dt' => 1),
			array('db' => 'fk_forne',  'dt' => 2),
			array(
				'db'        => 'valor_unitario',
				'dt'        => 3,
				'formatter' => function ($d, $row) {
					return 'R$ ' . number_format($d,2,",",".");
				}
			),
			array('db' => 'quantidade',     'dt' => 4),
			array('db' => 'prazo_validade',     'dt' => 5),
			array('db' => 'data_compra',     'dt' => 6),
			array(
				'db'        => 'id_prod_pk',
				'dt'        => 7,
				'formatter' => function( $d) {
					return "<a href='" . base_url('dashboard/editar/').$d." 'target=''><i class='fa fa-pencil' aria-hidden='true'></i></a><a class='space-icons' href='" . base_url('dashboard/excluir/').$d." 'target=''><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
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
		$this->dashboard_model->excluiProduto((int)$id);
		$this->session->set_userdata('excluir', 'ok');
		
		redirect('dashboard/consultar/produtos');
	}
}
