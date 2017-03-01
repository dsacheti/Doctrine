<?php

namespace SiApi\Entity;

use Doctrine\ORM\EntityRepository;
use  Doctrine\ORM\Tools\Pagination\Paginator;

class CategoriaRepository extends EntityRepository
{
    public function getAllAscNome()
    {
        $dql = "SELECT cat FROM SiApi\Entity\Categoria cat ORDER BY cat.nome ASC";
        $consulta = $this->getEntityManager()->createQuery($dql);
        return $consulta->getResult();
    }

    public function getAllDescNome()
    {
        $dql = "SELECT cat FROM SiApi\Entity\Categoria cat ORDER BY cat.nome DESC";
        $consulta = $this->getEntityManager()->createQuery($dql);
        return $consulta->getResult();
    }

    public function getAllDescId()
    {
        $dql = "SELECT cat FROM SiApi\Entity\Categoria cat ORDER BY cat.id DESC";
        $consulta = $this->getEntityManager()->createQuery($dql);
        return $consulta->getResult();
    }

    public function getPagedCategorias($inicial,$max)
    {
        $dql = "SELECT cat FROM SiApi\Entity\Categoria cat ORDER BY cat.id ASC";
        $consulta = $this->getEntityManager()->createQuery($dql)
            ->setFirstResult($inicial)
            ->setMaxResults($max);

        $paginator = new Paginator($consulta);
        return $paginator;
    }

    public function findNome($nome)
    {
        $queryB = $this->getEntityManager()->createQueryBuilder();
        return $queryB->select('cat')
            ->from('SiApi\Entity\Categoria', 'cat')
            ->where('cat.nome = :nm')
            ->setParameter('nm', $nome)
            ->getQuery()
            ->getResult();
    }

    public function findNomeContains($nm)
    {
        $dql = "SELECT cat FROM SiApi\Entity\Categoria cat WHERE cat.nome LIKE :nm";
        $consulta = $this->getEntityManager()->createQuery($dql)->setParameter('nm','%'.$nm.'%');
        return $consulta->getResult();
    }

}