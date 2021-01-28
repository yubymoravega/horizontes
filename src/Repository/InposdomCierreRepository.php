<?php

namespace App\Repository;

use App\Entity\InposdomCierre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InposdomCierre|null find($id, $lockMode = null, $lockVersion = null)
 * @method InposdomCierre|null findOneBy(array $criteria, array $orderBy = null)
 * @method InposdomCierre[]    findAll()
 * @method InposdomCierre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InposdomCierreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InposdomCierre::class);
    }

    // /**
    //  * @return InposdomCierre[] Returns an array of InposdomCierre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InposdomCierre
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
