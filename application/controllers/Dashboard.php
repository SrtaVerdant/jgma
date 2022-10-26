<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require './vendor/autoload.php';

class Dashboard extends CI_Controller{
	function __construct(){
		parent::__construct();

		$this->load->helper('url');
//		$this->load->model('');
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
		echo "em construção";
	}

	public function LoadConsultar()	{
		echo "em construção 2";
	}

	public function LoadRelatorio()	{
		echo "em construção 3";
	}





	
}
