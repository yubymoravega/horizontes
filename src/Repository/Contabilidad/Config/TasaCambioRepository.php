<?php

namespace App\Repository\Contabilidad\Config;

use App\Entity\Contabilidad\Config\TasaCambio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TasaCambio|null find($id, $lockMode = null, $lockVersion = null)
 * @method TasaCambio|null findOneBy(array $criteria, array $orderBy = null)
 * @method TasaCambio[]    findAll()
 * @method TasaCambio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TasaCambioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TasaCambio::class);
    }

    // /**
    //  * @return TasaCambio[] Returns an array of TasaCambio objects
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
    public function findOneBySomeField($value): ?TasaCambio
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
