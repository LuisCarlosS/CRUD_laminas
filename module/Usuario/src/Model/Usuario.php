<?php

namespace Usuario\Model;

class Usuario
{
    public $id;
    public $nome;
    public $email;
    public $senha;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->nome = !empty($data['nome']) ? $data['nome'] : null;
        $this->email  = !empty($data['email']) ? $data['email'] : null;
        $this->senha  = !empty($data['senha']) ? $data['senha'] : null;
    }
}