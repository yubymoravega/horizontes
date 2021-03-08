<?php

namespace App\Repository\Contabilidad\Config;

use App\Entity\Contabilidad\Config\CategoriaCliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoriaCliente|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoriaCliente|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoriaCliente[]    findAll()
 * @method CategoriaCliente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriaClienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoriaCliente::class);
    }

    // /**
    //  * @return CategoriaCliente[] Returns an array of CategoriaCliente objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategoriaCliente
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
