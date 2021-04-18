<?php
namespace Application\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Categoria extends \ArrayObject implements InputFilterAwareInterface
{
    public $id_categoria_planejamento;
    public $nome_categoria;
    
    public function exchangeArray($data)
    {
        $this->id_categoria_planejamento = $data['id_categoria_planejamento'] ? (int) $data['id_categoria_planejamento'] : null;
        $this->nome_categoria = $data['nome_categoria'] ? $data['nome_categoria'] : null;
    }
    
    public function getArrayCopy()
    {
        return array(
            'id_categoria_planejamento' => $this->id_categoria_planejamento,
            'nome_categoria' => $this->nome_categoria
            );
    }
    
    /**
     * Sem Uso no momento
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Sem uso");
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            
            $inputFilter->add(array(
                'name'     => 'id_categoria_planejamento',
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));
            
            $inputFilter->add(array(
                'name'     => 'nome_categoria',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 150,
                        ),
                    ),
                ),
            ));
            
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}