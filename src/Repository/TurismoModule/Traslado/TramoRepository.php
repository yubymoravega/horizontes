<?php

namespace App\Repository\TurismoModule\Traslado;

use App\Entity\TurismoModule\Traslado\Tramo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tramo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tramo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tramo[]    findAll()
 * @method Tramo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TramoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tramo::class);
    }

    // /**
    //  * @return Tramo[] Returns an array of Tramo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tramo
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
