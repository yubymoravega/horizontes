<?php

namespace App\Repository\Contabilidad\Config;

use App\Entity\Contabilidad\Config\PeriodoSistema;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PeriodoSistema|null find($id, $lockMode = null, $lockVersion = null)
 * @method PeriodoSistema|null findOneBy(array $criteria, array $orderBy = null)
 * @method PeriodoSistema[]    findAll()
 * @method PeriodoSistema[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PeriodoSistemaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PeriodoSistema::class);
    }

    // /**
    //  * @return PeriodoSistema[] Returns an array of PeriodoSistema objects
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
    public function findOneBySomeField($value): ?PeriodoSistema
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
