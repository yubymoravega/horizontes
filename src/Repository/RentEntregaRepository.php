<?php

namespace App\Repository;

use App\Entity\RentEntrega;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RentEntrega|null find($id, $lockMode = null, $lockVersion = null)
 * @method RentEntrega|null findOneBy(array $criteria, array $orderBy = null)
 * @method RentEntrega[]    findAll()
 * @method RentEntrega[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentEntregaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RentEntrega::class);
    }

    // /**
    //  * @return RentEntrega[] Returns an array of RentEntrega objects
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
    public function findOneBySomeField($value): ?RentEntrega
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
