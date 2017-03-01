<?php

namespace SiApi\Entity;

use Doctrine\ORM\EntityRepository;
use  Doctrine\ORM\Tools\Pagination\Paginator;

class TagRepository extends EntityRepository
{
    public function getAllAscNome()
    {
        $dql = "SELECT t FROM SiApi\Entity\Tag t ORDER BY t.nome ASC";
        $consulta = $this->getEntityManager()->createQuery($dql);
        return $consulta->getResult();
    }

    public function getAllDescNome()
    {
        $dql = "SELECT t FROM SiApi\Entity\Tag t ORDER BY t.nome DESC";
        $consulta = $this->getEntityManager()->createQuery($dql);
        return $consulta->getResult();
    }

    public function getAllDescId()
    {
        $dql = "SELECT t FROM SiApi\Entity\Tag t ORDER BY t.id DESC";
        $consulta = $this->getEntityManager()->createQuery($dql);
        return $consulta->getResult();
    }

    public function getPagedTags($inicial,$max)
    {
        $dql = "SELECT t FROM SiApi\Entity\Tag t ORDER BY t.id ASC";
        $consulta = $this->getEntityManager()->createQuery($dql)
            ->setFirstResult($inicial)
            ->setMaxResults($max);

        $paginator = new Paginator($consulta);
        return $paginator;
    }

    public function findNome($nome)
    {
        $queryB = $this->getEntityManager()->createQueryBuilder();
        return $queryB->select('tag')
            ->from('SiApi\Entity\Tag', 'tag')
            ->where('tag.nome = :nm')
            ->setParameter('nm', $nome)
            ->getQuery()
            ->getResult();
    }

    public function findNomeContains($nm)
    {
        $dql = "SELECT tag FROM SiApi\Entity\Tag tag WHERE tag.nome LIKE :nm";
        $consulta = $this->getEntityManager()->createQuery($dql)->setParameter('nm','%'.$nm.'%');
        return $consulta->getResult();
    }
}