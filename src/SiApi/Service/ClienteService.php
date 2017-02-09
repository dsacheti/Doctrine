<?php

namespace SiApi\Service;

use SiApi\Entity\Clientes;
use SiApi\Mapper\ClienteMapper;

class ClienteService
{

    /**
     * @var Clientes
     */
    private $cliente;
    /**
     * @var ClienteMapper
     */
    private $clienteMapper;

    public function __construct(Clientes $cliente, ClienteMapper $clienteMapper)
    {
        $this->cliente = $cliente;
        $this->clienteMapper = $clienteMapper;
    }

    public function insert(array $data)
    {
        $clienteEntity = $this->cliente;
        $clienteEntity->setNome($data['nome']);
        $clienteEntity->setEmail($data['email']);

        $mapper = $this->clienteMapper;
        return $mapper->insert($clienteEntity);

    }

    public function fetchAll()
    {
        $mapper = $this->clienteMapper;
        return $mapper->fetchAll();
    }


    public function find(int $id)
    {
        $mapper = $this->clienteMapper;
        return $mapper->find($id);
    }

    public function update(int $id,array $arr)
    {
        $mapper = $this->clienteMapper;
        return $mapper->update($id,$arr);
    }

    public function delete(int $id)
    {
        $mapper = $this->clienteMapper;
        return $mapper->delete($id);
    }
}