<?php

namespace App\Repository\Contabilidad\General;

use App\Entity\Contabilidad\General\ObligacionPago;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ObligacionPago|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObligacionPago|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObligacionPago[]    findAll()
 * @method ObligacionPago[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObligacionPagoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObligacionPago::class);
    }

    // /**
    //  * @return ObligacionPago[] Returns an array of ObligacionPago objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ObligacionPago
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
