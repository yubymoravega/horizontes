<?php

namespace App\Repository\Contabilidad\Inventario;

use App\Entity\Contabilidad\Inventario\ValeSalida;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ValeSalida|null find($id, $lockMode = null, $lockVersion = null)
 * @method ValeSalida|null findOneBy(array $criteria, array $orderBy = null)
 * @method ValeSalida[]    findAll()
 * @method ValeSalida[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValeSalidaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ValeSalida::class);
    }

    // /**
    //  * @return ValeSalida[] Returns an array of ValeSalida objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ValeSalida
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
