<?php

namespace Application\Controller;

use Application\Form\ProdutoForm;
use Application\Model\Produto;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProdutoController extends AbstractActionController
{
    protected $produtoTable;
    protected $categoriaTable;
    
    function getCategoriaTable()
    {
        if(!$this->categoriaTable){
            $this->categoriaTable = $this->getServiceLocator()->get('Application\Model\CategoriaTable');
        }
        return $this->categoriaTable;
    }
    
    function getProdutoTable()
    {
        if(!$this->produtoTable){
            $this->produtoTable = $this->getServiceLocator()->get('Application\Model\ProdutoTable');
        }
        return $this->produtoTable;
    }
    
    public function indexAction()
    {
        return new ViewModel(array(
                'produtos' => $this->getProdutoTable()->fetchAll(),
                'categorias' => $this->getCategoriasList()
            )
        );
    }
    
    public function adicionarAction()
    {
        $form = new ProdutoForm();
        
        $request = $this->getRequest();
        if($request->isPost()){
            $produto = new Produto();
            $form->setInputFilter($produto->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()){
                $produto->exchangeArray($form->getData());
                $this->getProdutoTable()->save($produto);
                return $this->redirect()->toRoute('produto');
            }
        }
    
        $form->get('id_categoria_produto')->setValueOptions($this->getCategoriasList());
        
        return new ViewModel(array('form' => $form));
    }
    
    public function editarAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if(!$id) return $this->redirect()->toRoute('produto');
    
        try {
            $produto = $this->getProdutoTable()->getProduto($id);
        }catch(\Exception $e){
            return $this->redirect()->toRoute('produto');
        }
        
        $form = new ProdutoForm();
        $form->bind($produto);
        $form->get('salvar')->setAttribute('value','Atualizar');
    
        $erros = array();
        $request = $this->getRequest();
        if($request->isPost()){
            $produto = new Produto();
            $form->setInputFilter($produto->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()){
                $produto->exchangeArray($request->getPost());
                try{
                    $this->getProdutoTable()->save($produto);
                }catch (\Exception $e){
                    $erros[] = $e->getMessage();
                }
                return $this->redirect()->toRoute('produto');
            }
        }
    
        $form->get('id_categoria_produto')->setValueOptions($this->getCategoriasList());
        return new ViewModel(array('form' => $form, 'id' => $id));
    }
    
    public function removerAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if($id) $this->getProdutoTable()->deleteProduto($id);
        return $this->redirect()->toRoute('produto');
    }
    
    protected function getCategoriasList()
    {
        $categoriasList = $this->getCategoriaTable()->fetchAll()->toArray();
        $categorias = array();
        foreach($categoriasList as $produto)
            $categorias[$produto['id_categoria_planejamento']] = $produto['nome_categoria'];
        
        return $categorias;
    }
}

