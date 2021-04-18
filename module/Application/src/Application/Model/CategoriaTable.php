<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class CategoriaTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway){
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }
    
    public function getCategoria($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id_categoria_planejamento' => $id));
        $row = $rowset->current();
        if (!$row) throw new \Exception("Não foi possível encontrar a categoria $id");
        
        return $row;
    }
    
    public function save(Categoria $categoria)
    {
        $data = array(
            'nome_categoria' => $categoria->nome_categoria
        );
        $id = (int) $categoria->id_categoria_planejamento;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCategoria($id)) {
                $this->tableGateway->update($data, array('id_categoria_planejamento' => $id));
            } else {
                throw new \Exception('Categoria não existe');
            }
        }
    }
    
    public function deleteCategoria($id)
    {
        $this->tableGateway->delete(array('id_categoria_planejamento' => (int) $id));
    }
}