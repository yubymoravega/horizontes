<?php

namespace App\Repository;

use App\Entity\Agencias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Agencias|null find($id, $lockMode = null, $lockVersion = null)
 * @method Agencias|null findOneBy(array $criteria, array $orderBy = null)
 * @method Agencias[]    findAll()
 * @method Agencias[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgenciasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agencias::class);
    }

    // /**
    //  * @return Agencias[] Returns an array of Agencias objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Agencias
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
