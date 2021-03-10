<?php

namespace App\Repository;

use App\Entity\PlazosPagoCotizacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlazosPagoCotizacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlazosPagoCotizacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlazosPagoCotizacion[]    findAll()
 * @method PlazosPagoCotizacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlazosPagoCotizacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlazosPagoCotizacion::class);
    }

    // /**
    //  * @return PlazosPagoCotizacion[] Returns an array of PlazosPagoCotizacion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlazosPagoCotizacion
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
