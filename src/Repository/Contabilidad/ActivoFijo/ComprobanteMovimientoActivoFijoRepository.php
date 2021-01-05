<?php

namespace App\Repository\Contabilidad\ActivoFijo;

use App\Entity\Contabilidad\ActivoFijo\ComprobanteMovimientoActivoFijo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ComprobanteMovimientoActivoFijo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComprobanteMovimientoActivoFijo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComprobanteMovimientoActivoFijo[]    findAll()
 * @method ComprobanteMovimientoActivoFijo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComprobanteMovimientoActivoFijoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComprobanteMovimientoActivoFijo::class);
    }

    // /**
    //  * @return ComprobanteMovimientoActivoFijo[] Returns an array of ComprobanteMovimientoActivoFijo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ComprobanteMovimientoActivoFijo
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
