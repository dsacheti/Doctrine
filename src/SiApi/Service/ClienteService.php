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
        if($this->validarString($data['nome'])) {
            $cliente->setNome($data['nome']);
        } else {
            return ['Erro' => 'O nome não pode ficar em branco'];
        }
        if($this->validarString($data['email'])) {
            $cliente->setEmail($data['email']);
        } else {
            return ['Erro' => 'O email não pode ficar em branco'];
        }

        $this->em->persist($cliente);
        $this->em->flush();
        return ['Sucesso' =>'Cliente '.$cliente->getNome().' cadastrado.'];
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
        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhum resultado encontado'];
        }
    }

    public function update(int $id,array $arr)
    {
        $cliente = $this->em->getReference('SiApi\Entity\Cliente',$id);
        if($this->validarString($arr['nome'])) {
            $cliente->setNome($arr['nome']);
        } else {
            return ['Erro' => 'O nome não pode ficar em branco'];
        }
        if($this->validarString($arr['email'])) {
            $cliente->setEmail($arr['email']);
        } else {
            return ['Erro' => 'O email não pode ficar em branco'];
        }

        $this->em->persist($cliente);
        $this->em->flush();
        return ['Sucesso' =>'Os dados do cliente '.$cliente->getNome().' foram atualizados'];
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
        $resultado =  $this->parseResult($pg);

        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhum resultado encontado'];
        }
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
        $resultado =  $this->parseResult($pg);

        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhum resultado encontado'];
        }
    }

    public function buscarNome($nome)
    {
        $repositorio = $this->em->getRepository('SiApi\Entity\Cliente');
        $lista = $repositorio->findNome($nome);
        $resultado = $this->parseResult($lista);
        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhum cliente encontado com o nome '.$nome];
        }
    }

    public function buscarEmail($email)
    {
        $repositorio = $this->em->getRepository('SiApi\Entity\Cliente');
        $lista = $repositorio->findEmail($email);
        $resultado =  $this->parseResult($lista);

        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhum cliente encontado com o email: '.$email];
        }
    }

    public function buscarNomeContem($nm)
    {
        $repositorio = $this->em->getRepository('SiApi\Entity\Cliente');
        $lista = $repositorio->findNomeContains($nm);
        $resultado = $this->parseResult($lista);

        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhum cliente encontrado com '.$nm.' no nome'];
        }
    }

    public function buscarEmailContem($mail)
    {
        $repositorio = $this->em->getRepository('SiApi\Entity\Cliente');
        $lista = $repositorio->findEmailContains($mail);
        $resultado =  $this->parseResult($lista);

        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhum cliente encontado com '.$mail.' no email'];
        }
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

    private function validarString($entrada)
    {
        $entrada = trim($entrada);
        if (!strlen($entrada) > 0 ) {
            return false;
        } else {
            return true;
        }
    }
}