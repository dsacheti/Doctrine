<?php

namespace SiApi\Service;

use Doctrine\Common\Collections\ArrayCollection;
use SiApi\Entity\Produto;
use Doctrine\Orm\EntityManager;

class ProdutoService
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
        $produto = new Produto();
        if($this->validarString($data['nome'])) {
            $produto->setNome($data['nome']);
        } else {
            return ['Erro' => 'O nome não pode ficar em branco'];
        }

        if ($this->validarString($data['desc'])) {
            $produto->setDescricao($data['desc']);
        } else {
            return ['Erro' => 'A descrição não pode ficar em branco'];
        }

        if ($this->validarNum($data['valor'])) {
            if( strpos($data['valor'],'.') !== false) {
                $produto->setValor('R$ ' . str_replace('.', ',', $data['valor']));
            }
        } else if(strpos($data['valor'],',') !== false) {
            return ['Erro' => 'Use ponto para separar os centavos, o sistema fará a conversão'];
        } else {
            return ['Erro' => 'Verifique o valor do produto. ATENÇÃO, este campo aceita somente números'];
        }

        if ($data['categoria']) {
            $categoria = $this->em->getReference('SiApi\Entity\Categoria',$data['categoria']);
            $produto->setCategoria($categoria);
        }

        if ($data['tags']) {
            $tags = explode(",",$data['tags']);
            foreach ($tags as $tag) {
                $tagEntity = $this->em->getReference('SiApi\Entity\Tag',$tag);
                $produto->addTag($tagEntity);
            }
        }

        $this->em->persist($produto);
        $this->em->flush();
        return ['Sucesso' =>'Um produto com nome '.$produto->getNome().' foi cadastrado.'];
    }

    public function fetchAll()
    {
        $repository = $this->em->getRepository('SiApi\Entity\Produto');
        $lista = $repository->getAllAscNome();

        return $this->parseResult($lista);
    }


    public function find(int $id)
    {
        $repository = $this->em->getRepository('SiApi\Entity\Produto');
        $produto =  $repository->find($id);
        $p =0;
        $tags = array();
        foreach ($produto->getTags() as $tag) {
            $tags[$p] = $tag->getNome();
        }
        $resultado = [
            'id' => $produto->getId(),
            'nome' => $produto->getNome(),
            'descricao' => $produto->getDescricao(),
            'valor' => $produto->getValor(),
            'categoria' =>$produto->getCategoria()->getNome(),
            'tags' => $tags
        ];
        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhum resultado encontado'];
        }
    }

    public function update(int $id,array $arr)
    {
        $produto = $this->em->getReference('SiApi\Entity\Produto',$id);
        if($this->validarString($arr['nome'])) {
            $produto->setNome($arr['nome']);
        } else {
            return ['Erro' => 'O nome não pode ficar em branco'];
        }

        if($this->validarString($arr['desc'])) {
            $produto->setDescricao($arr['desc']);
        } else {
            return ['Erro' => 'A descrição não pode ficar em branco'];
        }

        if ($this->validarNum($arr['valor'])) {
            if( strpos($arr['valor'],'.') !== false) {
                $produto->setValor('R$ ' . str_replace('.', ',', $arr['valor']));
            }
        } else if(strpos($arr['valor'],',') !== false) {
            return ['Erro' => 'Use ponto para separar os centavos, o sistema fará a conversão'];
        } else {
            return ['Erro' => 'Verifique o valor do produto. ATENÇÃO, este campo aceita somente números'];
        }

        if ($arr['categoria']) {
            $categoria = $this->em->getReference('SiApi\Entity\Categoria',$arr['categoria']);
            $produto->setCategoria($categoria);
        }

        if ($arr['tags']) {
            $tags = explode(",",$arr['tags']);
            $tagEntity = new ArrayCollection();
            foreach ($tags as $tag) {
                $tagEntity->add($this->em->getReference('SiApi\Entity\Tag',$tag));
            }
            $produto->putTags($tagEntity);
        }

        $this->em->persist($produto);
        $this->em->flush();
        return ['Sucesso' =>'Os dados do cliente '.$produto->getNome().' foram atualizados'];
    }

    public function delete(int $id)
    {
        $repositorio = $this->em->getReference('SiApi\Entity\Produto',$id);
        $this->em->remove($repositorio);
        $this->em->flush();
        return ['Sucesso' =>'Produto apagado.'];
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

        $repo = $this->em->getRepository('SiApi\Entity\Produto');
        $pg = $repo->getPagedProdutos($inicial,$max);
        $resultado =  $this->parseResult($pg);

        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhum resultado encontado'];
        }
    }

    public function buscarPorTag($tag)
    {
        $repositorio = $this->em->getRepository('SiApi\Entity\Tag');
        $lista = $repositorio->findNome($tag);
        $resultado = array();
        $i =0;
        foreach ($lista as $item) {

            $j =0;
            $resultado[$i]['Tag'] = $item->getNome();
            foreach ($item->getProdutos() as $prod) {
                $resultado[$i]['Produtos'][$j] = [ 'Nome' => $prod->getNome(),
                    'Descrição' => $prod->getDescricao(),
                    'Valor' => $prod->getValor()
                ];
                $j++;
            }
            $i++;
        }
        //retornando um array
        return $resultado;

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

        $repositorio = $this->em->getRepository('SiApi\Entity\Produto');
        $pg = $repositorio->getPagedProdutos($inicial,$max);
        $resultado =  $this->parseResult($pg);

        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhum resultado encontado'];
        }
    }

    public function buscarNome($nome)
    {
        $repositorio = $this->em->getRepository('SiApi\Entity\Produto');
        $lista = $repositorio->findNome($nome);
        $resultado = $this->parseResult($lista);
        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhum cliente encontado com o nome '.$nome];
        }
    }


    public function buscarNomeContem($nm)
    {
        $repositorio = $this->em->getRepository('SiApi\Entity\Produto');
        $lista = $repositorio->findNomeContains($nm);
        $resultado = $this->parseResult($lista);

        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhum produto encontrado com '.$nm.' no nome'];
        }
    }

    public function buscarDescContem($desc)
    {
        $repositorio = $this->em->getRepository('SiApi\Entity\Produto');
        $lista = $repositorio->findDescContains($desc);
        $resultado =  $this->parseResult($lista);

        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhum produto encontado com '.$desc.' na descrição'];
        }
    }

    public function buscarPorCategoria($categoria)
    {
        $repositorio = $this->em->getRepository('SiApi\Entity\Produto');
        $lista = $repositorio->findCategoria($categoria);
        $resultado =  $this->parseResult($lista);

        if (!empty($resultado)) {
            return $resultado;
        } else {
            return ['Erro' => 'Nenhum produto encontado nesta categoria'];
        }
    }

   //o parametro deve ser um array de SiApi\Entity\Produto
    private function parseResult($lista)
    {
        $resultado = array();
        $i =0;
        foreach ($lista as $item) {
            $resultado[$i]['id'] = $item->getId();
            $resultado[$i]['nome'] = $item->getNome();
            $resultado[$i]['descricao'] = $item->getDescricao();
            $resultado[$i]['valor'] = $item->getValor();
            $resultado[$i]['categoria'] = $item->getCategoria()->getNome();
            $j =0;
            foreach ($item->getTags() as $tag) {
                $resultado[$i]['Tag'][$j] = $tag->getNome();
                $j++;
            }
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

    private function validarNum($entrada)
    {
        if (!is_numeric($entrada) or ($entrada <= 0)) {
            return false;
        } else {
            return true;
        }
    }
}