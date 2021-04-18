<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class ProdutoTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway){
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function getProduto($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id_produto' => $id));
        $row = $rowset->current();
        if (!$row) throw new \Exception("Não foi possível encontrar o produto $id");
        
        return $row;
    }
    
    public function save(Produto $produto)
    {
        $data = array(
            'id_categoria_produto' => 0 !== ((int) $produto->id_categoria_produto) ? (int) $produto->id_categoria_produto : null,
            'nome_produto' => $produto->nome_produto,
            'valor_produto' => number_format((float) str_replace(',','.',$produto->valor_produto),2,'.','')
        );
        
        $id = (int) $produto->id_produto;
        
        if ($id == 0) {
            $data['data_cadastro'] = date('Y-m-d');
            $this->tableGateway->insert($data);
        } else {
            if ($this->getProduto($id)) {
                $this->tableGateway->update($data, array('id_produto' => $id));
            } else {
                throw new \Exception('Categoria não existe');
            }
        }
    }
    
    public function deleteProduto($id)
    {
        $this->tableGateway->delete(array('id_produto' => (int) $id));
    }
}