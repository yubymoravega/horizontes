<?php

namespace App\Repository;

use App\Entity\StripeFactura;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StripeFactura|null find($id, $lockMode = null, $lockVersion = null)
 * @method StripeFactura|null findOneBy(array $criteria, array $orderBy = null)
 * @method StripeFactura[]    findAll()
 * @method StripeFactura[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StripeFacturaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StripeFactura::class);
    }

    // /**
    //  * @return StripeFactura[] Returns an array of StripeFactura objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StripeFactura
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
