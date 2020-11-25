<?php

namespace App\Repository;

use App\Entity\HotelDestino;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HotelDestino|null find($id, $lockMode = null, $lockVersion = null)
 * @method HotelDestino|null findOneBy(array $criteria, array $orderBy = null)
 * @method HotelDestino[]    findAll()
 * @method HotelDestino[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HotelDestinoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HotelDestino::class);
    }

    // /**
    //  * @return HotelDestino[] Returns an array of HotelDestino objects
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
    public function findOneBySomeField($value): ?HotelDestino
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
