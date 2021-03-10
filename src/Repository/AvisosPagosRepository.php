<?php

namespace App\Repository;

use App\Entity\AvisosPagos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AvisosPagos|null find($id, $lockMode = null, $lockVersion = null)
 * @method AvisosPagos|null findOneBy(array $criteria, array $orderBy = null)
 * @method AvisosPagos[]    findAll()
 * @method AvisosPagos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvisosPagosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AvisosPagos::class);
    }

    // /**
    //  * @return AvisosPagos[] Returns an array of AvisosPagos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AvisosPagos
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
