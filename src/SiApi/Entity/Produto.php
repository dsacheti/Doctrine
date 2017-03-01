<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 24/02/2017
 * Time: 17:13
 */

namespace SiApi\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="SiApi\Entity\ProdutoRepository")
 * @ORM\Table(name="produtos")
 */
class Produto
{
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     *
     * @ORM\Column(type="string",length=100)
     */
    private $nome;

    /**
     *
     * @ORM\Column(type="string",length=255)
     */
    private $descricao;

    /**
     *
     * @ORM\Column(type="string",length=20)
     */
    private $valor;

    /**
     * Many Produtos have One Categoria.
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     */
    private $categoria;

    /**
     * One Produto have Many tags
     * @ORM\ManyToMany(targetEntity="SiApi\Entity\Tag")
     * @ORM\JoinTable(name="produtos_tags",
     *     joinColumns={@ORM\JoinColumn(name="produto_id",referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="tag_id",referencedColumnName="id")}
     *  )
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     * @return Produto
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     * @return Produto
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     * @return Produto
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param mixed $categoria
     * @return Produto
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function putTags($tags)
    {
        $this->tags->clear();
        foreach($tags as $t) {
            $this->tags->add($t);
        }
    }
    /**
     * @param ArrayCollection $tags
     * @return Produto
     */
    public function addTag($tag): Produto
    {
        $this->tags->add($tag);
        return $this;
    }


}