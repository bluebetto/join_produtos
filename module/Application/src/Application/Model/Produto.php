<?php


namespace Application\Model;


use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;

class Produto extends \ArrayObject
{
    public $id_produto;
    public $id_categoria_produto;
    public $data_cadastro;
    public $nome_produto;
    public $valor_produto;
    
    public function exchangeArray($data)
    {
        $this->id_produto = $data['id_produto'] ? (int) $data['id_produto'] : null;
        $this->id_categoria_produto = $data['id_categoria_produto'] ? (int) $data['id_categoria_produto'] : null;
        $this->data_cadastro = $data['data_cadastro'] ? $data['data_cadastro'] : null;
        $this->nome_produto = $data['nome_produto'] ? $data['nome_produto'] : null;
        $this->valor_produto = (float) $data['valor_produto'] ? $data['valor_produto'] : null;
    }
    
    public function getArrayCopy()
    {
        return array(
            'id_produto' => $this->id_produto,
            'id_categoria_produto' => $this->id_categoria_produto,
            'data_cadastro' => $this->data_cadastro,
            'nome_produto' => $this->nome_produto,
            'valor_produto' => $this->valor_produto
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
                'name'     => 'id_produto',
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));
    
            $inputFilter->add(array(
                'name'     => 'id_categoria_produto',
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));
            
            $inputFilter->add(array(
                'name'     => 'valor_produto',
                'required' => false
            ));
            
            $inputFilter->add(array(
                'name'     => 'nome_produto',
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