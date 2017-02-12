<?php

namespace SiApi\Mapper;

use SiApi\Entity\Cliente;
use Doctrine\ORM\EntityManager;

class ClienteMapper {
    
    private $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    private $dados = [
        0 => [
            'nome' => 'NomeCliente',
            'email' => 'emailCliente@host.com.br'
        ],
        1 => [
            'nome' => 'NomeOutoCliente',
            'email' => 'emailOutroCliente@host.com.br'
        ]
    ];

    public function insert(Cliente $cliente)
    {
        $this->em->persist($cliente);
        $this->em->flush();
        return [
            'Sucesso' =>'Cliente Cadastrado',
            'id' => $cliente->getId(),
            'nome' => $cliente->getNome(),
            'email' =>$cliente->getEmail()
        ];

    }

    public function fetchAll()
    {
        $lista = $this->em->getRepository('SiApi\Entity\Cliente')->findAll();
        return $lista;

    }

    public function find($id)
    {
        return $this->dados[$id];
    }

    public function update($id,Cliente $cliente)
    {
        $entity = $this->em->getRepository('SiApi\Entity\Cliente')->find($id);
        $entity->setNome($cliente->getNome());
        $entity->setEmail($cliente->getEmail());
        $this->em->flush();

        return ['Sucesso' =>'Cliente: '.$cliente->getNome().' atualizado com sucesso'];
    }

    public function delete($id)
    {
        $entity = $this->em->getRepository('SiApi\Entity\Cliente')->find($id);
        $this->em->remove($entity);
        $this->em->flush();
        return ['Sucesso'=>'Cliente: '.$entity->getNome().' apagado'];
    }
}
