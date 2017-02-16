<?php

namespace SiApi\Service;

use SiApi\Entity\Cliente;
use Doctrine\Orm\EntityManager;

class ClienteService
{

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function insert(array $data)
    {
        $cliente = new Cliente();
        $cliente = new Cliente();
        $cliente->setNome($data['nome']);
        $cliente->setEmail($data['email']);

        $this->em->persist($cliente);
        $this->em->flush();
    }

    public function fetchAll()
    {
        $repository = $this->em->getRepository('SiApi\Entity\Cliente');
        $lista = $repository->getAllAsc();

        return $this->parseResult($lista);
    }


    public function find(int $id)
    {
        $repository = $this->em->getRepository('SiApi\Entity\Cliente');
        $cliente =  $repository->find($id);
        $resultado = [
            'id' => $cliente->getId(),
            'nome' => $cliente->getNome(),
            'email' => $cliente->getEmail()
        ];
        return $resultado;
    }

    public function update(int $id,array $arr)
    {
        $cliente = $this->em->getReference('SiApi\Entity\Cliente',$id);

        $cliente->setNome($arr['nome']);
        $cliente->setEmail($arr['email']);

        $this->em->persist($cliente);
        $this->em->flush();
        return ['Sucesso' =>'Os dados do cliente foram atualizados'];
    }

    public function delete(int $id)
    {
        $repositorio = $this->em->getReference('SiApi\Entity\Cliente',$id);
        $this->em->remove($repositorio);
        $this->em->flush();
        return ['Sucesso' =>'Cliente apagado.'];
    }

    public function fetchPageSimple($pagina)
    {
        if (!is_numeric($pagina)) {
            return ['Erro' =>'A página deve ser um número'];
        } else if($pagina <= 0) {
            $pagina = 1;
        }

        $max = 10;
        $inicial =1;
        if ($pagina > 1) {
            //se a página for 2, por exemplo, para que não inicie no 20 mas sim no 11 temos:
            $inicial = ($max * $pagina) - ($max-1);
        }

        $repo = $this->em->getRepository('SiApi\Entity\Cliente');
        $pg = $repo->getPagedClientes($inicial,$max);
        return $this->parseResult($pg);
    }

    public function fetchPage($pagina,$numRes)
    {
        if (!is_numeric($pagina)) {
            return ['Erro' =>'A página deve ser um número'];
        } else if($pagina <= 0) {
            $pagina = 1;
        }

        if (!is_numeric($numRes)) {
            return ['Erro'=>'Você deve espedificar um NUMERO de resultados'];
        } else if($numRes <= 0) {
            $numRes =1;
        }

        $max = $numRes;
        $inicial =1;
        if ($pagina > 1) {
            //se a página for 2, por exemplo, para que não inicie no 20 mas sim no 11 temos:
            $inicial = ($max * $pagina) - ($max-1);
        }

        $repositorio = $this->em->getRepository('SiApi\Entity\Cliente');
        $pg = $repositorio->getPagedClientes($inicial,$max);
        return $this->parseResult($pg);
    }

    public function buscar($param)
    {
        $cliente = new Cliente();
        $repositorio = $this->em->getRepository('SiApi\Entity\Cliente');
        if (filter_var($param, FILTER_VALIDATE_EMAIL)) {
            $cliente = $repositorio->findEmail($param);
        }
        $cliente = $repositorio->findNome($param);
        $resultado = [
            'id' => $cliente->getId(),
            'nome' => $cliente->getNome(),
            'email' => $cliente->getEmail()
        ];
        return $resultado;
    }

    //o parametro deve ser um array de SiApi\Entity\Cliente
    private function parseResult($lista)
    {
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
}