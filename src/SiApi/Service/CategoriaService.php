<?php

namespace SiApi\Service;

use SiApi\Entity\Categoria;
use Doctrine\Orm\EntityManager;

class CategoriaService
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
        $categoria = new Categoria();
        if($this->validarString($data['nome'])) {
            $categoria->setNome($data['nome']);
        } else {
            return ['Erro' => 'O nome não pode ficar em branco'];
        }

        $this->em->persist($categoria);
        $this->em->flush();
        return ['Sucesso' =>'Uma categoria com nome '.$categoria->getNome().' foi cadastrada.'];
    }

    public function fetchAll()
    {
        $repository = $this->em->getRepository('SiApi\Entity\Categoria');
        $lista = $repository->getAllAscNome();

        return $this->parseResult($lista);
    }


    public function find(int $id)
    {
        $repository = $this->em->getRepository('SiApi\Entity\Categoria');
        $categoria =  $repository->find($id);
        $resultado = [
            'id' => $categoria->getId(),
            'nome' => $categoria->getNome()
        ];
        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhum resultado encontado'];
        }
    }

    public function update(int $id,array $arr)
    {
        $categoria = $this->em->getReference('SiApi\Entity\Categoria',$id);
        if($this->validarString($arr['nome'])) {
            $categoria->setNome($arr['nome']);
        } else {
            return ['Erro' => 'O nome não pode ficar em branco'];
        }


        $this->em->persist($categoria);
        $this->em->flush();
        return ['Sucesso' =>'Agora o nome da categoria é '.$categoria->getNome()];
    }

    public function delete(int $id)
    {
        $repositorio = $this->em->getReference('SiApi\Entity\Categoria',$id);
        $this->em->remove($repositorio);
        $this->em->flush();
        return ['Sucesso' =>'Categoria apagada.'];
    }

    public function fetchPageSimple($pagina)
    {
        if (!is_numeric($pagina)) {
            return ['Erro' =>'A página deve ser um número'];
        } else if($pagina <= 0) {
            $pagina = 1;
        }

        $max = 10;
        $inicial =0;
        if ($pagina > 1) {
            //se a página for 2, por exemplo, para que não inicie no 20 mas sim no 11 temos:
            $inicial = ($max * $pagina) - ($max-1);
        }

        $repo = $this->em->getRepository('SiApi\Entity\Categoria');
        $pg = $repo->getPagedCategorias($inicial,$max);
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
            return ['Erro'=>'Você deve espedificar um NUMERO de resultados por página'];
        } else if($numRes <= 0) {
            $numRes =1;
        }

        $max = $numRes;
        $inicial =0;
        if ($pagina > 1) {
            //se a página for 2, por exemplo, para que não inicie no 20 mas sim no 11 temos:
            $inicial = ($max * $pagina) - ($max-1);
        }

        $repositorio = $this->em->getRepository('SiApi\Entity\Categoria');
        $pg = $repositorio->getPagedCategorias($inicial,$max);
        $resultado =  $this->parseResult($pg);

        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhum resultado encontado'];
        }
    }

    public function buscarNome($nome)
    {
        $repositorio = $this->em->getRepository('SiApi\Entity\Categoria');
        $lista = $repositorio->findNome($nome);
        $resultado = $this->parseResult($lista);
        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhuma categoria encontada com o nome '.$nome];
        }
    }

    public function buscarNomeContem($nm)
    {
        $repositorio = $this->em->getRepository('SiApi\Entity\Categoria');
        $lista = $repositorio->findNomeContains($nm);
        $resultado = $this->parseResult($lista);

        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhuma categoria encontrada com '.$nm.' no nome'];
        }
    }

    //o parametro deve ser um array de SiApi\Entity\Categoria
    private function parseResult($lista)
    {
        $resultado = array();
        $i =0;
        foreach ($lista as $item) {
            $resultado[$i]['id'] = $item->getId();
            $resultado[$i]['nome'] = $item->getNome();
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