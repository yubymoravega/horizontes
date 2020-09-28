<?php

namespace App\Repository;

use App\Entity\TasaDeCambio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TasaDeCambio|null find($id, $lockMode = null, $lockVersion = null)
 * @method TasaDeCambio|null findOneBy(array $criteria, array $orderBy = null)
 * @method TasaDeCambio[]    findAll()
 * @method TasaDeCambio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TasaDeCambioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TasaDeCambio::class);
    }

    // /**
    //  * @return TasaDeCambio[] Returns an array of TasaDeCambio objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TasaDeCambio
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
