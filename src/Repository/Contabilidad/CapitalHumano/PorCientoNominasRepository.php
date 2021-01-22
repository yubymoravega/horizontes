<?php

namespace App\Repository\Contabilidad\CapitalHumano;

use App\Entity\Contabilidad\CapitalHumano\PorCientoNominas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PorCientoNominas|null find($id, $lockMode = null, $lockVersion = null)
 * @method PorCientoNominas|null findOneBy(array $criteria, array $orderBy = null)
 * @method PorCientoNominas[]    findAll()
 * @method PorCientoNominas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PorCientoNominasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PorCientoNominas::class);
    }

    // /**
    //  * @return PorCientoNominas[] Returns an array of PorCientoNominas objects
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
    public function findOneBySomeField($value): ?PorCientoNominas
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
