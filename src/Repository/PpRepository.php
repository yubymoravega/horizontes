<?php

namespace App\Repository;

use App\Entity\Pp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pp|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pp|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pp[]    findAll()
 * @method Pp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pp::class);
    }

    // /**
    //  * @return Pp[] Returns an array of Pp objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pp
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
