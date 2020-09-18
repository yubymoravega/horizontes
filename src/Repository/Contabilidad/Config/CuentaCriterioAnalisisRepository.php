<?php

namespace App\Repository\Contabilidad\Config;

use App\Entity\Contabilidad\Config\CuentaCriterioAnalisis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CuentaCriterioAnalisis|null find($id, $lockMode = null, $lockVersion = null)
 * @method CuentaCriterioAnalisis|null findOneBy(array $criteria, array $orderBy = null)
 * @method CuentaCriterioAnalisis[]    findAll()
 * @method CuentaCriterioAnalisis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CuentaCriterioAnalisisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CuentaCriterioAnalisis::class);
    }

    // /**
    //  * @return CuentaCriterioAnalisis[] Returns an array of CuentaCriterioAnalisis objects
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
    public function findOneBySomeField($value): ?CuentaCriterioAnalisis
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
