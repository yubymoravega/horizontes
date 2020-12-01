<?php

namespace App\Repository;

use App\Entity\ReporteEfectivo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReporteEfectivo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReporteEfectivo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReporteEfectivo[]    findAll()
 * @method ReporteEfectivo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReporteEfectivoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReporteEfectivo::class);
    }

    // /**
    //  * @return ReporteEfectivo[] Returns an array of ReporteEfectivo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReporteEfectivo
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
