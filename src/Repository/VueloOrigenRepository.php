<?php

namespace App\Repository;

use App\Entity\VueloOrigen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VueloOrigen|null find($id, $lockMode = null, $lockVersion = null)
 * @method VueloOrigen|null findOneBy(array $criteria, array $orderBy = null)
 * @method VueloOrigen[]    findAll()
 * @method VueloOrigen[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VueloOrigenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VueloOrigen::class);
    }

    // /**
    //  * @return VueloOrigen[] Returns an array of VueloOrigen objects
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
    public function findOneBySomeField($value): ?VueloOrigen
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
