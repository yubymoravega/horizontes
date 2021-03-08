<?php

namespace App\Repository;

use App\Entity\SolicitudTurismo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SolicitudTurismo|null find($id, $lockMode = null, $lockVersion = null)
 * @method SolicitudTurismo|null findOneBy(array $criteria, array $orderBy = null)
 * @method SolicitudTurismo[]    findAll()
 * @method SolicitudTurismo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolicitudTurismoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SolicitudTurismo::class);
    }

    // /**
    //  * @return SolicitudTurismo[] Returns an array of SolicitudTurismo objects
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
    public function findOneBySomeField($value): ?SolicitudTurismo
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
