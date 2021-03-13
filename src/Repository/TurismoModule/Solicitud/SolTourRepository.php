<?php

namespace App\Repository\TurismoModule\Solicitud;

use App\Entity\TurismoModule\Solicitud\SolTour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SolTour|null find($id, $lockMode = null, $lockVersion = null)
 * @method SolTour|null findOneBy(array $criteria, array $orderBy = null)
 * @method SolTour[]    findAll()
 * @method SolTour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolTourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SolTour::class);
    }

    // /**
    //  * @return SolTour[] Returns an array of SolTour objects
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
    public function findOneBySomeField($value): ?SolTour
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
