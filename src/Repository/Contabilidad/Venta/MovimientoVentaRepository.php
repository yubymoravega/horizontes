<?php

namespace App\Repository\Contabilidad\Venta;

use App\Entity\Contabilidad\Venta\MovimientoVenta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MovimientoVenta|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovimientoVenta|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovimientoVenta[]    findAll()
 * @method MovimientoVenta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovimientoVentaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovimientoVenta::class);
    }

    // /**
    //  * @return MovimientoVenta[] Returns an array of MovimientoVenta objects
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
    public function findOneBySomeField($value): ?MovimientoVenta
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
