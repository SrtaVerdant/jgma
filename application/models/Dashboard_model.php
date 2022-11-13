<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

  function __construct()
  {
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
    $this->db->set('nome', $produto['nome']);
    $this->db->set('fk_forne', $produto['fk_fornecedor']);
    $this->db->set('fk_funcional', $produto['funcional']);
    $this->db->set('valor_unitario', $produto['preco_unitario']);
    // $this->db->set('fk_tipo', $produto['tipo']);
    $this->db->set('quantidade', $produto['qtd']);
    $this->db->set('prazo_validade', $produto['data_validade']);
    $this->db->set('data_compra', $produto['data_compra']);
    $this->db->insert('produtos');
  }

  public function getProdutoById($id)
  {
    $this->db->select('*');
    $this->db->where('id_prod_pk', $id);
    $query = $this->db->get('produtos')->result();

    return $query[0];
  }

  public function editaProduto($produto)
  {
    $this->db->set('nome', $produto['nome']);
    $this->db->set('fk_forne', $produto['fk_fornecedor']);
    $this->db->set('fk_funcional', $produto['funcional']);
    $this->db->set('valor_unitario', $produto['preco_unitario']);
    $this->db->set('quantidade', $produto['qtd']);
    // $this->db->set('fk_tipo', $produto['tipo']);
    $this->db->set('prazo_validade', $produto['data_validade']);
    $this->db->set('data_compra', $produto['data_compra']);
    $this->db->where('id_prod_pk', $produto['id']);
    $this->db->update('produtos');
  }

  public function getAllProdutos()
  {
    $this->db->select('*');
    $query = $this->db->get('produtos')->result();

    return $query;
  }

  public function excluiProduto($id)
  {
    $this->db->where('id_prod_pk', $id);
    $this->db->delete('produtos');
  }
}
