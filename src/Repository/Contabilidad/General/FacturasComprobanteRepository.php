<?php

namespace App\Repository\Contabilidad\General;

use App\Entity\Contabilidad\General\FacturasComprobante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FacturasComprobante|null find($id, $lockMode = null, $lockVersion = null)
 * @method FacturasComprobante|null findOneBy(array $criteria, array $orderBy = null)
 * @method FacturasComprobante[]    findAll()
 * @method FacturasComprobante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacturasComprobanteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FacturasComprobante::class);
    }

    // /**
    //  * @return FacturasComprobante[] Returns an array of FacturasComprobante objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FacturasComprobante
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
