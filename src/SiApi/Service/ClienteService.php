<?php

namespace SiApi\Service;

use SiApi\Entity\Cliente;
use SiApi\Mapper\ClienteMapper;

class ClienteService
{

    /**
     * @var Cliente
     */
    private $cliente;
    /**
     * @var ClienteMapper
     */
    private $clienteMapper;

    public function __construct(Cliente $cliente, ClienteMapper $clienteMapper)
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
        $lista =  $mapper->fetchAll();

        //transformando Cliente em array
        $resultado = array();
        $i =0;
        foreach ($lista as $item) {
            $resultado[$i]['id'] = $item->getId();
            $resultado[$i]['nome'] = $item->getNome();
            $resultado[$i]['email'] = $item->getEmail();
            $i++;
        }
        //retornando um array
        return $resultado;
    }


    public function find(int $id)
    {
        $mapper = $this->clienteMapper;
        return $mapper->find($id);
    }

    public function update($id,array $arr)
    {
        $mapper = $this->clienteMapper;
        $entity = $this->cliente;

        $entity->setNome($arr['nome']);
        $entity->setEmail($arr['email']);
        return $mapper->update($id,$entity);
    }

    public function delete(int $id)
    {
        $mapper = $this->clienteMapper;
        return $mapper->delete($id);
    }
}