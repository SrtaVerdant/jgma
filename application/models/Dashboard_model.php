<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model{

    function __construct(){
		parent::__construct();
	}

    public function getAllFornecedores()
    {
		$this->db->select('*');
		$query = $this->db->get('fornecedores')->result();

		return $query;
	}

    public function cadastraProduto($produto)
    {   
        $this->db->select('*');
		$this->db->set('nome', $produto['nome']);
		$this->db->set('fk_forne', $produto['fk_fornecedor']);
        $this->db->set('fk_funcional', $produto['funcional']);
        $this->db->set('valor_unitario', $produto['preco_unitario']);
        $this->db->set('quantidade', $produto['qtd']);
        $this->db->set('prazo_validade', $produto['data_validade']);
        $this->db->set('data_compra', $produto['data_compra']);
		$this->db->insert('produtos');    
    }

}