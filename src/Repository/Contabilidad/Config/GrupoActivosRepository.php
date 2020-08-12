<?php

namespace App\Repository\Contabilidad\Config;

use App\Entity\Contabilidad\Config\GrupoActivos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GrupoActivos|null find($id, $lockMode = null, $lockVersion = null)
 * @method GrupoActivos|null findOneBy(array $criteria, array $orderBy = null)
 * @method GrupoActivos[]    findAll()
 * @method GrupoActivos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GrupoActivosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GrupoActivos::class);
    }

    // /**
    //  * @return GrupoActivos[] Returns an array of GrupoActivos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GrupoActivos
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
