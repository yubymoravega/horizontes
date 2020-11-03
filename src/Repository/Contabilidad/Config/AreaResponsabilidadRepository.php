<?php

namespace App\Repository\Contabilidad\Config;

use App\Entity\Contabilidad\Config\AreaResponsabilidad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AreaResponsabilidad|null find($id, $lockMode = null, $lockVersion = null)
 * @method AreaResponsabilidad|null findOneBy(array $criteria, array $orderBy = null)
 * @method AreaResponsabilidad[]    findAll()
 * @method AreaResponsabilidad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AreaResponsabilidadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AreaResponsabilidad::class);
    }

    // /**
    //  * @return AreaResponsabilidad[] Returns an array of AreaResponsabilidad objects
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
    public function findOneBySomeField($value): ?AreaResponsabilidad
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
