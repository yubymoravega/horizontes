<?php

namespace App\Repository\Contabilidad\ActivoFijo;

use App\Entity\Contabilidad\ActivoFijo\MovimientoActivoFijo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MovimientoActivoFijo|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovimientoActivoFijo|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovimientoActivoFijo[]    findAll()
 * @method MovimientoActivoFijo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovimientoActivoFijoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovimientoActivoFijo::class);
    }

    // /**
    //  * @return MovimientoActivoFijo[] Returns an array of MovimientoActivoFijo objects
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
    public function findOneBySomeField($value): ?MovimientoActivoFijo
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
