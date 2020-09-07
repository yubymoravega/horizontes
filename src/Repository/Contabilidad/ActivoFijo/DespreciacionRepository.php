<?php

namespace App\Repository\Contabilidad\ActivoFijo;

use App\Entity\Contabilidad\ActivoFijo\Depreciacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Depreciacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Depreciacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Depreciacion[]    findAll()
 * @method Depreciacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DespreciacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Depreciacion::class);
    }

    // /**
    //  * @return Depreciacion[] Returns an array of Depreciacion objects
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
    public function findOneBySomeField($value): ?Depreciacion
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
