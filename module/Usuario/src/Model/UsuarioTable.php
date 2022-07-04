<?php

namespace Usuario\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class UsuarioTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getUsuario($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveUsuario(Usuario $usuario)
    {
        $data = [
            'nome' => $usuario->nome,
            'email'  => $usuario->email,
            'senha'  => $usuario->senha,
        ];

        $id = (int) $usuario->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getUsuario($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update usuario with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteUsuario($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}