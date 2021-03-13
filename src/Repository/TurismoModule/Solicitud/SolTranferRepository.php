<?php

namespace App\Repository\TurismoModule\Solicitud;

use App\Entity\TurismoModule\Solicitud\SolTranfer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SolTranfer|null find($id, $lockMode = null, $lockVersion = null)
 * @method SolTranfer|null findOneBy(array $criteria, array $orderBy = null)
 * @method SolTranfer[]    findAll()
 * @method SolTranfer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolTranferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SolTranfer::class);
    }

    // /**
    //  * @return SolTranfer[] Returns an array of SolTranfer objects
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
    public function findOneBySomeField($value): ?SolTranfer
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
