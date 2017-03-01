<?php


namespace SiApi\Entity;


use Doctrine\ORM\EntityRepository;
use  Doctrine\ORM\Tools\Pagination\Paginator;

class ProdutoRepository extends EntityRepository
{
    public function getAllAscNome()
    {
        $dql = "SELECT p FROM SiApi\Entity\Produto p ORDER BY p.nome ASC";
        $consulta = $this->getEntityManager()->createQuery($dql);
        return $consulta->getResult();
    }

    public function getProdutosDesc()
    {
        $dql = "SELECT p FROM SiApi\Entity\Produto p ORDER BY p.nome desc";
        return $this->getEntityManager()
            ->createQuery($dql)
            ->getResult();
    }

    public function getPagedProdutos($inicial,$max)
    {
        $dql = "SELECT p FROM SiApi\Entity\Produto p";
        $consulta = $this->getEntityManager()->createQuery($dql)
            ->setFirstResult($inicial)
            ->setMaxResults($max);

        $paginator = new Paginator($consulta);
        return $paginator;
    }

    public function findNome($nome)
    {
        $queryB = $this->getEntityManager()->createQueryBuilder();
        return $queryB->select('p')
            ->from('SiApi\Entity\Produto', 'p')
            ->where('p.nome = :nm')
            ->setParameter('nm', $nome)
            ->getQuery()
            ->getResult();
    }

    public function findCategoria($cat)
    {
        $queryB = $this->getEntityManager()->createQueryBuilder();
        return $queryB->select('p')
            ->from('SiApi\Entity\Produto', 'p')
            ->where('p.categoria = :cat')
            ->setParameter('cat', $cat)
            ->getQuery()
            ->getResult();
    }

    public function findNomeContains($nome)
    {
        $dql = "SELECT p FROM SiApi\Entity\Produto p WHERE p.descricao LIKE :nm";
        $consulta = $this->getEntityManager()->createQuery($dql)->setParameter('nm','%'.$nome.'%');
        return $consulta->getResult();
    }

    public function findDescContains($desc)
    {
        $dql = "SELECT p FROM SiApi\Entity\Produto p WHERE p.descricao LIKE :desc";
        $consulta = $this->getEntityManager()->createQuery($dql)->setParameter('desc','%'.$desc.'%');
        return $consulta->getResult();
    }

}