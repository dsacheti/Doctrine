<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 24/02/2017
 * Time: 15:52
 */

namespace SiApi\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 *
 * @ORM\Entity(repositoryClass="SiApi\Entity\TagRepository")
 * @ORM\Table(name="tags")
 */
class Tag
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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }


}