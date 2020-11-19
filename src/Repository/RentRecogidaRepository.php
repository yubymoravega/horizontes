<?php

namespace App\Repository;

use App\Entity\RentRecogida;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RentRecogida|null find($id, $lockMode = null, $lockVersion = null)
 * @method RentRecogida|null findOneBy(array $criteria, array $orderBy = null)
 * @method RentRecogida[]    findAll()
 * @method RentRecogida[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentRecogidaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RentRecogida::class);
    }

    // /**
    //  * @return RentRecogida[] Returns an array of RentRecogida objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RentRecogida
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
