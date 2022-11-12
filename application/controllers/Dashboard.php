<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require './vendor/autoload.php';

class Dashboard extends CI_Controller{
	function __construct(){
		parent::__construct();

		$this->load->model('dashboard_model');
	}

	public function home(){

		$dados['titulo'] = 'Dashboard';

		if ($this->session->userdata('login') == 'ok') {
			$this->load->view('dashboard/dashboard', $dados);
		}else{
			redirect('');	
		}

	}

	public function LoadInserir() {		

		if ($this->session->userdata('login') == 'ok') {

			$dados['titulo'] = 'Inserir produto';			
			$dados['fornecedores'] = $this->dashboard_model->getAllFornecedores();

			$this->load->view('crud/inserir', $dados);
		}else{
			redirect('');	
		}
	}

	public function inserirProduto() {
		
		$this->session->set_userdata('inserir', '');

		$produto = array(	'funcional' =>	(int)$this->session->userdata('funcional'),
							'nome' => $this->input->post('produto'),
							'qtd' => (int)$this->input->post('quantidade'),
							'fk_fornecedor' => (int)$this->input->post('fornecedor'),
							'data_validade' => $this->input->post('validade'),
							'fk_tipo' => $this->input->post('tipo'),
							'data_compra' => $this->input->post('datacompra'),
							'preco_unitario' => formataMoedaDecimal($this->input->post('preco')));

		if ($produto['fk_fornecedor'] == '-' || $produto['preco_unitario'] == 0.00 || empty(trim($produto['qtd']))) {
			$this->session->set_userdata('inserir', 'erro');			
		}else{
			$this->dashboard_model->cadastraProduto($produto);
			$this->session->set_userdata('inserir', 'ok');
		}	
		
		redirect('dashboard');
	}

	public function LoadConsultar()	{
		echo "em construção 2";
	}

	public function LoadRelatorio()	{
		echo "em construção 3";
	}





	
}
