<?php


namespace SiApi\Entity;


use Doctrine\ORM\EntityRepository;
use  Doctrine\ORM\Tools\Pagination\Paginator;

class ClienteRepository extends EntityRepository
{
    public function getAllAsc()
    {
        $dql = "SELECT cli FROM SiApi\Entity\Cliente cli ORDER BY cli.nome ASC";
        $consulta = $this->getEntityManager()->createQuery($dql);
        return $consulta->getResult();
    }

    public function getClientesDesc()
    {
        $dql = "SELECT cli FROM SiApi\Entity\Cliente cli ORDER BY cli.nome desc";
        return $this->getEntityManager()
            ->createQuery($dql)
            ->getResult();
    }

    public function getPagedClientes($inicial,$max)
    {
        $dql = "SELECT cli FROM SiApi\Entity\Cliente cli ORDER BY cli.id ASC";
        $consulta = $this->getEntityManager()->createQuery($dql)
            ->setFirstResult($inicial)
            ->setMaxResults($max);

        $paginator = new Paginator($consulta);
        return $paginator;
    }

    public function findNome($nome)
    {
        $queryB = $this->getEntityManager()->createQueryBuilder();
        return $queryB->select('cli')
            ->from('SiApi\Entity\Cliente', 'cli')
            ->where('cli.nome = :nm')
            ->setParameter('nm', $nome)
            ->getQuery()
            ->getResult();
    }


    public function findEmail($email)
    {
        $queryB = $this->getEntityManager()->createQueryBuilder();
        return $queryB->select('cli')
            ->from('SiApi\Entity\Cliente', 'cli')
            ->where('cli.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getResult();
    }
}