<?php

namespace App\Repository\Contabilidad\ActivoFijo;

use App\Entity\Contabilidad\ActivoFijo\ActivoFijoMovimientoActivoFijo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ActivoFijoMovimientoActivoFijo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActivoFijoMovimientoActivoFijo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActivoFijoMovimientoActivoFijo[]    findAll()
 * @method ActivoFijoMovimientoActivoFijo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivoFijoMovimientoActivoFijoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivoFijoMovimientoActivoFijo::class);
    }

    // /**
    //  * @return ActivoFijoMovimientoActivoFijo[] Returns an array of ActivoFijoMovimientoActivoFijo objects
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
    public function findOneBySomeField($value): ?ActivoFijoMovimientoActivoFijo
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
