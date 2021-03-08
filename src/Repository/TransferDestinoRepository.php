<?php

namespace App\Repository;

use App\Entity\TransferDestino;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TransferDestino|null find($id, $lockMode = null, $lockVersion = null)
 * @method TransferDestino|null findOneBy(array $criteria, array $orderBy = null)
 * @method TransferDestino[]    findAll()
 * @method TransferDestino[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransferDestinoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TransferDestino::class);
    }

    // /**
    //  * @return TransferDestino[] Returns an array of TransferDestino objects
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
    public function findOneBySomeField($value): ?TransferDestino
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
