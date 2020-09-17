<?php

namespace App\Repository\Contabilidad\Config;

use App\Entity\Contabilidad\Config\CriterioAnalisis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CriterioAnalisis|null find($id, $lockMode = null, $lockVersion = null)
 * @method CriterioAnalisis|null findOneBy(array $criteria, array $orderBy = null)
 * @method CriterioAnalisis[]    findAll()
 * @method CriterioAnalisis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CriterioAnalisisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CriterioAnalisis::class);
    }

    // /**
    //  * @return CriterioAnalisis[] Returns an array of CriterioAnalisis objects
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
    public function findOneBySomeField($value): ?CriterioAnalisis
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
