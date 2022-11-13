<?php
defined('BASEPATH') or exit('No direct script access allowed');
require './vendor/autoload.php';

class Funcionarios extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->model('funcionarios_model');
	}


	public function index()
	{

		$dados['titulo'] = 'Login';

		$this->session->set_userdata('loginInvalido', $this->session->userdata('tentativasLog'));
		// $this->session->set_userdata('login', '');

		$this->load->view('login/login', $dados);
	}

	public function login()
	{

		$dados = array(
			'funcional' => (int)$this->input->post('funcional'),
			'senha' => $this->input->post('senha')
		);

		$this->funcionarios_model->validaCadastro($dados);

		if ($this->session->userdata('login') == 'ok') {
			redirect('dashboard');
		} else {
			$this->validacao();
			redirect('');
		}
	}

	public function validacao()
	{

		$cont = $this->session->userdata('loginInvalido');
		$cont++;
		$this->session->set_userdata('tentativasLog', $cont);
	}


	public function recuperarSenha()
	{

		$dados['titulo'] = 'Recuperar senha';

		$this->session->set_userdata('login', '');

		$this->load->view('login/recuperar-senha', $dados);
	}

	public function logout()
	{

		$this->session->sess_destroy();

		redirect('', 'refresh');
	}

	public function recuperar()
	{

		if ($this->funcionarios_model->recuperarSenha(formataCPF($this->input->post('cpf')))) {
			$this->session->set_userdata('recuperacpf', 'ok');
			$this->session->set_userdata('tentativasLog', '');
		} else {
			$this->session->set_userdata('recuperacpf', 'erro');
		}

		redirect('recuperar-senha');
	}
}
