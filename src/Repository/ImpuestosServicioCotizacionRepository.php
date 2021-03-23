<?php

namespace App\Repository;

use App\Entity\ImpuestosServicioCotizacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImpuestosServicioCotizacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImpuestosServicioCotizacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImpuestosServicioCotizacion[]    findAll()
 * @method ImpuestosServicioCotizacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImpuestosServicioCotizacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImpuestosServicioCotizacion::class);
    }

    // /**
    //  * @return ImpuestosServicioCotizacion[] Returns an array of ImpuestosServicioCotizacion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImpuestosServicioCotizacion
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
