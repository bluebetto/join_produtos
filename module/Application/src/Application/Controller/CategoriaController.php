<?php

namespace Application\Controller;

use Application\Form\CategoriaForm;
use Application\Model\Categoria;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CategoriaController extends AbstractActionController
{
    protected $categoriaTable;
    
    function getCategoriaTable()
    {
        if(!$this->categoriaTable){
            $this->categoriaTable = $this->getServiceLocator()->get('Application\Model\CategoriaTable');
        }
        return $this->categoriaTable;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'categorias' => $this->getCategoriaTable()->fetchAll()
        ));
    }
    
    public function adicionarAction()
    {
        $form = new CategoriaForm();
        $request = $this->getRequest();
        if($request->isPost()){
            $categoria = new Categoria();
            $form->setInputFilter($categoria->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()){
                $categoria->exchangeArray($form->getData());
                $this->getCategoriaTable()->save($categoria);
                return $this->redirect()->toRoute('categoria');
            }
        }
        return new ViewModel(array('form' => $form));
    }
    
    public function editarAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id) return $this->redirect()->toRoute('categoria');
        
        try {
            $categoria = $this->getCategoriaTable()->getCategoria($id);
        }catch(\Exception $e){
            return $this->redirect()->toRoute('categoria');
        }
        
        $form = new CategoriaForm();
        $form->bind($categoria);
        $form->get('salvar')->setAttribute('value','Atualizar');
        $erros = array();
        $request = $this->getRequest();
        if($request->isPost()){
            $categoria = new Categoria();
            $form->setInputFilter($categoria->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()){
                $categoria->exchangeArray($request->getPost());
                try{
                    $this->getCategoriaTable()->save($categoria);
                }catch (\Exception $e){
                    $erros[] = $e->getMessage();
                }
                return $this->redirect()->toRoute('categoria');
            }
        }
        return new ViewModel(array('form' => $form, 'id' => $id, 'erros' => $erros));
    }
    
    public function removerAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if($id) $this->getCategoriaTable()->deleteCategoria($id);
        return $this->redirect()->toRoute('categoria');
    }
}
