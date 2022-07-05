<?php

namespace Usuario\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Usuario\Model\UsuarioTable;
use Usuario\Form\UsuarioForm;
use Usuario\Model\Usuario;

class UsuarioController extends AbstractActionController
{
    private $table;

    public function __construct(UsuarioTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        if($this->getRequest()->isPost()) {

            $nome = $this->getRequest("nome", "");
            
            return new ViewModel([
                'usuarios' => $this->table->buscar(array('nome' => $nome)),
            ]);

        }

        return new ViewModel([
            'usuarios' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new UsuarioForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $usuario = new Usuario();
        $form->setInputFilter($usuario->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $usuario->exchangeArray($form->getData());
        $this->table->saveUsuario($usuario);
        return $this->redirect()->toRoute('usuario');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('usuario', ['action' => 'add']);
        }

        try {
            $usuario = $this->table->getUsuario($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('usuario', ['action' => 'index']);
        }

        $form = new UsuarioForm();
        $form->bind($usuario);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($usuario->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        try {
            $this->table->saveUsuario($usuario);
        } catch (\Exception $e) {
        }

        return $this->redirect()->toRoute('usuario', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('usuario');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');

            if ($del == 'Sim') {
                $id = (int) $request->getPost('id');
                $this->table->deleteUsuario($id);
            }

            return $this->redirect()->toRoute('usuario');
        }

        return [
            'id'    => $id,
            'usuario' => $this->table->getUsuario($id),
        ];
    }
}