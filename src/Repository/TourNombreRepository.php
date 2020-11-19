<?php

namespace App\Repository;

use App\Entity\TourNombre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TourNombre|null find($id, $lockMode = null, $lockVersion = null)
 * @method TourNombre|null findOneBy(array $criteria, array $orderBy = null)
 * @method TourNombre[]    findAll()
 * @method TourNombre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TourNombreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TourNombre::class);
    }

    // /**
    //  * @return TourNombre[] Returns an array of TourNombre objects
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
    public function findOneBySomeField($value): ?TourNombre
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
