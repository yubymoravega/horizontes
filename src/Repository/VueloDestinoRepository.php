<?php

namespace App\Repository;

use App\Entity\VueloDestino;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VueloDestino|null find($id, $lockMode = null, $lockVersion = null)
 * @method VueloDestino|null findOneBy(array $criteria, array $orderBy = null)
 * @method VueloDestino[]    findAll()
 * @method VueloDestino[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VueloDestinoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VueloDestino::class);
    }

    // /**
    //  * @return VueloDestino[] Returns an array of VueloDestino objects
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
    public function findOneBySomeField($value): ?VueloDestino
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
