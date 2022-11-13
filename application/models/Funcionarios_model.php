<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Funcionarios_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function validaCadastro($dados)
	{

		$this->db->select('*');
		$this->db->where('funcional', $dados['funcional']);
		$this->db->where('senha', $dados['senha']);
		$query = $this->db->get('funcionarios')->result();

		//retorno de banco, nome, funcional e cargo
		if ($query) {
			$this->session->set_userdata('login', 'ok');
			$this->session->set_userdata('nome', $query[0]->nome);
			$this->session->set_userdata('funcional', $query[0]->funcional);
			$this->session->set_userdata('cargo', $query[0]->fk_cargo);
		} else {
			$this->session->set_userdata('login', 'erro');
		}
	}

	public function recuperarSenha($cpf)
	{

		$this->db->select('cpf, nome, funcional, senha');
		$this->db->where('cpf', $cpf);
		$query = $this->db->get('funcionarios')->result();

		if ($query) {
			$this->session->set_userdata('funcional', $query[0]->funcional);
			$this->session->set_userdata('senha', $query[0]->senha);
			return true;
		}
		return false;
	}
}
