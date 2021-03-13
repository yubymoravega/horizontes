<?php

namespace App\Repository\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Impuesto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Impuesto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Impuesto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Impuesto[]    findAll()
 * @method Impuesto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImpuestoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Impuesto::class);
    }

    // /**
    //  * @return Impuesto[] Returns an array of Impuesto objects
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
    public function findOneBySomeField($value): ?Impuesto
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
