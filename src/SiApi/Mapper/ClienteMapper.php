<?php

namespace SiApi\Mapper;

use SiApi\Entity\Clientes;
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

    public function insert(Clientes $cliente)
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

    public function fetchAll(){
        $dados = $this->dados;
        return $dados;
    }

    public function find($id){
        return $this->dados[$id];
    }

    public function update($id,$dados)
    {
        $this->dados[$id]['nome'] = $dados['nome'];
        $this->dados[$id]['email'] = $dados['email'];

       // return $this-
        return [
            'success' => true
        ];
    }
}
