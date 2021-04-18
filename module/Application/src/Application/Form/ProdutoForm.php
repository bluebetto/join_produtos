<?php
namespace Application\Form;

use Zend\Form\Form;

class ProdutoForm extends Form
{
    public function __construct($name = 'produto')
    {
        parent::__construct($name);
        
        $this->add(array(
            'name' => 'id_produto',
            'type' => 'hidden'
        ));
        
        $this->add(array(
            'name' => 'nome_produto',
            'type' => 'Text',
            'options' => array(
                'label' => 'Nome: '
            )
        ));
    
        $this->add(array(
            'name' => 'id_categoria_produto',
            'type' => 'Select',
            'options' => array(
                'label' => 'Categoria: ',
                'disable_inarray_validator' => true
            )
           
        ));
    
        $this->add(array(
            'name' => 'valor_produto',
            'type' => 'Text',
            'options' => array(
                'label' => 'Valor: R$ ',
                'empty_option' => 'Selecione uma categoria'
            ),
            'validators' => array(
                array(
                    'name' => 'Float',
                    'options' => array(
                        'min' => 0,
                        'locale' => 'pt_BR'
                    ),
                ),
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