<?php

namespace App\Repository;

use App\Entity\AgenciasTv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AgenciasTv|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgenciasTv|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgenciasTv[]    findAll()
 * @method AgenciasTv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgenciasTvRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgenciasTv::class);
    }

    // /**
    //  * @return AgenciasTv[] Returns an array of AgenciasTv objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AgenciasTv
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
