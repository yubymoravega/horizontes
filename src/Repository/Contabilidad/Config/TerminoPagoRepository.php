<?php

namespace App\Repository\Contabilidad\Config;

use App\Entity\Contabilidad\Config\TerminoPago;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TerminoPago|null find($id, $lockMode = null, $lockVersion = null)
 * @method TerminoPago|null findOneBy(array $criteria, array $orderBy = null)
 * @method TerminoPago[]    findAll()
 * @method TerminoPago[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TerminoPagoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TerminoPago::class);
    }

    // /**
    //  * @return TerminoPago[] Returns an array of TerminoPago objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TerminoPago
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
