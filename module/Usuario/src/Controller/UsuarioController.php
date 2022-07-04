<?php

namespace Usuario\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class UsuarioController extends AbstractActionController
{
    private $table;

    public function __construct(UsuarioTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'usuarios' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
}