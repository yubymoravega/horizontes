<?php

namespace App\Repository;

use App\Entity\Municipios;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Municipios|null find($id, $lockMode = null, $lockVersion = null)
 * @method Municipios|null findOneBy(array $criteria, array $orderBy = null)
 * @method Municipios[]    findAll()
 * @method Municipios[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MunicipiosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Municipios::class);
    }

    // /**
    //  * @return Municipios[] Returns an array of Municipios objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Municipios
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
