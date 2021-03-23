<?php

namespace App\Repository;

use App\Entity\DescuestosServiciosCotizacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DescuestosServiciosCotizacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method DescuestosServiciosCotizacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method DescuestosServiciosCotizacion[]    findAll()
 * @method DescuestosServiciosCotizacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DescuestosServiciosCotizacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DescuestosServiciosCotizacion::class);
    }

    // /**
    //  * @return DescuestosServiciosCotizacion[] Returns an array of DescuestosServiciosCotizacion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DescuestosServiciosCotizacion
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
