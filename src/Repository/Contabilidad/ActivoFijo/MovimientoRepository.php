<?php

namespace App\Repository\Contabilidad\ActivoFijo;

use App\Entity\Contabilidad\ActivoFijo\Movimiento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Movimiento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movimiento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movimiento[]    findAll()
 * @method Movimiento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovimientoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movimiento::class);
    }

    // /**
    //  * @return Movimiento[] Returns an array of Movimiento objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Movimiento
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
