<?php
namespace Application\Form;

use Zend\Form\Form;

class CategoriaForm extends Form
{
    public function __construct($name = 'categoria')
    {
        parent::__construct($name);
        
        $this->add(array(
            'name' => 'id_categoria_planejamento',
            'type' => 'hidden'
        ));
        
        $this->add(array(
            'name' => 'nome_categoria',
            'type' => 'Text',
            'options' => array(
                'label' => 'Nome: '
            )
        ));
        
        $this->add(array(
            'name' => 'salvar',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Salvar',
                'id' => 'salvarbtn'
            )
        ));
    }
}