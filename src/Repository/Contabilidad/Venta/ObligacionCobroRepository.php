<?php

namespace App\Repository\Contabilidad\Venta;

use App\Entity\Contabilidad\Venta\ObligacionCobro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ObligacionCobro|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObligacionCobro|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObligacionCobro[]    findAll()
 * @method ObligacionCobro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObligacionCobroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObligacionCobro::class);
    }

    // /**
    //  * @return ObligacionCobro[] Returns an array of ObligacionCobro objects
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
    public function findOneBySomeField($value): ?ObligacionCobro
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
