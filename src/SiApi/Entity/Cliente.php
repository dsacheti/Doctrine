<?php

namespace SiApi\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @ORM\Entity(repositoryClass="SiApi\Entity\ClienteRepository")
 * @ORM\Table(name="clientes")
 */
class Cliente
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
     * @ORM\Column(type="string",length=150)
     */
     private $email;

     /**
      * @return mixed
      */
     public function getNome()
     {
         return $this->nome;
     }

     /**
      * @param mixed $name
      */
     public function setNome($name)
     {
         $this->nome = $name;
     }

     /**
      * @return mixed
      */
     public function getEmail()
     {
         return $this->email;
     }

     /**
      * @param mixed $email
      */
     public function setEmail($email)
     {
                $this->email = $email;
     }

    function getId() {
        return $this->id;
    }
 }