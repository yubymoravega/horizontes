<?php

namespace App\Repository\Contabilidad\Config;

use App\Entity\Contabilidad\Config\SubcuentaCriterioAnalisis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubcuentaCriterioAnalisis|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubcuentaCriterioAnalisis|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubcuentaCriterioAnalisis[]    findAll()
 * @method SubcuentaCriterioAnalisis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubcuentaCriterioAnalisisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubcuentaCriterioAnalisis::class);
    }

    // /**
    //  * @return SubcuentaCriterioAnalisis[] Returns an array of SubcuentaCriterioAnalisis objects
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
    public function findOneBySomeField($value): ?SubcuentaCriterioAnalisis
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
