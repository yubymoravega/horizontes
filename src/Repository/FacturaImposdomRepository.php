<?php

namespace App\Repository;

use App\Entity\FacturaImposdom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FacturaImposdom|null find($id, $lockMode = null, $lockVersion = null)
 * @method FacturaImposdom|null findOneBy(array $criteria, array $orderBy = null)
 * @method FacturaImposdom[]    findAll()
 * @method FacturaImposdom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacturaImposdomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FacturaImposdom::class);
    }

    // /**
    //  * @return FacturaImposdom[] Returns an array of FacturaImposdom objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FacturaImposdom
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
