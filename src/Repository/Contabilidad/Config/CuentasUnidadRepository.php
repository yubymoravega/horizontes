<?php

namespace App\Repository\Contabilidad\Config;

use App\Entity\Contabilidad\Config\CuentasUnidad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CuentasUnidad|null find($id, $lockMode = null, $lockVersion = null)
 * @method CuentasUnidad|null findOneBy(array $criteria, array $orderBy = null)
 * @method CuentasUnidad[]    findAll()
 * @method CuentasUnidad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CuentasUnidadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CuentasUnidad::class);
    }

    // /**
    //  * @return CuentasUnidad[] Returns an array of CuentasUnidad objects
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
    public function findOneBySomeField($value): ?CuentasUnidad
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
