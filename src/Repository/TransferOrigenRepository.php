<?php

namespace App\Repository;

use App\Entity\TransferOrigen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TransferOrigen|null find($id, $lockMode = null, $lockVersion = null)
 * @method TransferOrigen|null findOneBy(array $criteria, array $orderBy = null)
 * @method TransferOrigen[]    findAll()
 * @method TransferOrigen[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransferOrigenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TransferOrigen::class);
    }

    // /**
    //  * @return TransferOrigen[] Returns an array of TransferOrigen objects
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
    public function findOneBySomeField($value): ?TransferOrigen
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
