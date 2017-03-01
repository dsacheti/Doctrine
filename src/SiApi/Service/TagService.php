<?php

namespace SiApi\Service;

use SiApi\Entity\Tag;
use Doctrine\Orm\EntityManager;

class TagService
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
        $tag = new Tag();
        if($this->validarString($data['nome'])) {
            $tag->setNome($data['nome']);
        } else {
            return ['Erro' => 'O nome não pode ficar em branco'];
        }


        $this->em->persist($tag);
        $this->em->flush();
        return ['Sucesso' =>'Tag '.$tag->getNome().' cadastrada.'];
    }

    public function fetchAll()
    {
        $repository = $this->em->getRepository('SiApi\Entity\Tag');
        $lista = $repository->getAllAscNome();

        return $this->parseResult($lista);
    }


    public function find(int $id)
    {
        $repository = $this->em->getRepository('SiApi\Entity\Tag');
        $tag =  $repository->find($id);
        $resultado = [
            'id' => $tag->getId(),
            'nome' => $tag->getNome()
        ];
        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhum resultado encontado'];
        }
    }

    public function update(int $id,array $arr)
    {
        $tag = $this->em->getReference('SiApi\Entity\Tag',$id);
        if($this->validarString($arr['nome'])) {
            $tag->setNome($arr['nome']);
        } else {
            return ['Erro' => 'O nome não pode ficar em branco'];
        }


        $this->em->persist($tag);
        $this->em->flush();
        return ['Sucesso' =>'Os dados da tag '.$tag->getNome().' foram atualizados'];
    }

    public function delete(int $id)
    {
        $repositorio = $this->em->getReference('SiApi\Entity\Tag',$id);
        $this->em->remove($repositorio);
        $this->em->flush();
        return ['Sucesso' =>'Tag apagada.'];
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
            $inicial = ($max * $pagina) - $max;
        }

        $repo = $this->em->getRepository('SiApi\Entity\Tag');
        $pg = $repo->getPagedTags($inicial,$max);
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
        $inicial =0;
        if ($pagina > 1) {
            //se a página for 2, por exemplo, para que não inicie no 20 mas sim no 11 temos:
            $inicial = ($max * $pagina) - $max;
        }

        $repositorio = $this->em->getRepository('SiApi\Entity\Tag');
        $pg = $repositorio->getPagedTags($inicial,$max);
        $resultado =  $this->parseResult($pg);

        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhum resultado encontado'];
        }
    }

    public function buscarNome($nome)
    {
        $repositorio = $this->em->getRepository('SiApi\Entity\Tag');
        $lista = $repositorio->findNome($nome);
        $resultado = $this->parseResult($lista);
        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhuma tag encontrada com o nome '.$nome];
        }
    }



    public function buscarNomeContem($nm)
    {
        $repositorio = $this->em->getRepository('SiApi\Entity\Tag');
        $lista = $repositorio->findNomeContains($nm);
        $resultado = $this->parseResult($lista);

        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhuma tag encontrado com '.$nm.' no nome'];
        }
    }



    //o parametro deve ser um array de SiApi\Entity\Tag
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