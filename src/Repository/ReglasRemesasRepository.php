<?php

namespace App\Repository;

use App\Entity\ReglasRemesas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReglasRemesas|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReglasRemesas|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReglasRemesas[]    findAll()
 * @method ReglasRemesas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReglasRemesasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReglasRemesas::class);
    }

    // /**
    //  * @return ReglasRemesas[] Returns an array of ReglasRemesas objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReglasRemesas
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
