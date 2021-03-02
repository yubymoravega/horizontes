<?php

namespace App\Repository\TurismoModule\Traslado;

use App\Entity\TurismoModule\Traslado\Aeropuerto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Aeropuerto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aeropuerto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aeropuerto[]    findAll()
 * @method Aeropuerto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AeropuertoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aeropuerto::class);
    }

    // /**
    //  * @return Aeropuerto[] Returns an array of Aeropuerto objects
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
    public function findOneBySomeField($value): ?Aeropuerto
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
