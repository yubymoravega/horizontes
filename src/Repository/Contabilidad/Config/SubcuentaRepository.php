<?php

namespace App\Repository\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Subcuenta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Subcuenta|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subcuenta|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subcuenta[]    findAll()
 * @method Subcuenta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubcuentaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subcuenta::class);
    }

    // /**
    //  * @return Subcuenta[] Returns an array of Subcuenta objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Subcuenta
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
