<?php

namespace App\Repository\Contabilidad\General;

use App\Entity\Contabilidad\General\Asiento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Asiento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Asiento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Asiento[]    findAll()
 * @method Asiento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AsientoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Asiento::class);
    }

    // /**
    //  * @return Asiento[] Returns an array of Asiento objects
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
    public function findOneBySomeField($value): ?Asiento
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
