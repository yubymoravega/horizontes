<?php

namespace App\Repository\Contabilidad\CapitalHumano;

use App\Entity\Contabilidad\CapitalHumano\RangoEscalaDGII;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RangoEscalaDGII|null find($id, $lockMode = null, $lockVersion = null)
 * @method RangoEscalaDGII|null findOneBy(array $criteria, array $orderBy = null)
 * @method RangoEscalaDGII[]    findAll()
 * @method RangoEscalaDGII[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RangoEscalaDGIIRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RangoEscalaDGII::class);
    }

    // /**
    //  * @return RangoEscalaDGII[] Returns an array of RangoEscalaDGII objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RangoEscalaDGII
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
