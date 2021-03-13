<?php

namespace App\Repository\TurismoModule\hotel;

use App\Entity\TurismoModule\hotel\PlanHotel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlanHotel|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlanHotel|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlanHotel[]    findAll()
 * @method PlanHotel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanHotelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlanHotel::class);
    }

    // /**
    //  * @return PlanHotel[] Returns an array of PlanHotel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlanHotel
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
