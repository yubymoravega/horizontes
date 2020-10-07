<?php

namespace App\Repository;

use App\Entity\Trasacciones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trasacciones|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trasacciones|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trasacciones[]    findAll()
 * @method Trasacciones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrasaccionesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trasacciones::class);
    }

    // /**
    //  * @return Trasacciones[] Returns an array of Trasacciones objects
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
    public function findOneBySomeField($value): ?Trasacciones
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
