<?php

namespace SiApi\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @ORM\Entity
 * @ORM\Table(name="clientes")
 */
class Clientes
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

                 public function getAll(){
                $cli = [
                        'clientes' =>[
                                    [
                                            'nome' => 'Jovair',
                                            'email' => 'jovair@hotmail.com'
                                            ],
                                    [
                                            'nome' => 'Nelson',
                                            'email' => 'nelson@hotmail.com'
                                            ],
                                    [
                                            'nome' => 'Richard',
                                            'email' => 'richard@hotmail.com'
                                            ],
                                ]
                        ];
                return $cli;
     }
 }