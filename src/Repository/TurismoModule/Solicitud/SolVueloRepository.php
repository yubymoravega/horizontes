<?php

namespace App\Repository\TurismoModule\Solicitud;

use App\Entity\TurismoModule\Solicitud\SolVuelo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SolVuelo|null find($id, $lockMode = null, $lockVersion = null)
 * @method SolVuelo|null findOneBy(array $criteria, array $orderBy = null)
 * @method SolVuelo[]    findAll()
 * @method SolVuelo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolVueloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SolVuelo::class);
    }

    // /**
    //  * @return SolVuelo[] Returns an array of SolVuelo objects
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
    public function findOneBySomeField($value): ?SolVuelo
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
