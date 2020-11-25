<?php

namespace App\Repository;

use App\Entity\HotelOrigen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HotelOrigen|null find($id, $lockMode = null, $lockVersion = null)
 * @method HotelOrigen|null findOneBy(array $criteria, array $orderBy = null)
 * @method HotelOrigen[]    findAll()
 * @method HotelOrigen[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HotelOrigenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HotelOrigen::class);
    }

    // /**
    //  * @return HotelOrigen[] Returns an array of HotelOrigen objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HotelOrigen
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
