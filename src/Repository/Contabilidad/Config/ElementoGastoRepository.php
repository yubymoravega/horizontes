<?php

namespace App\Repository\Contabilidad\Config;

use App\Entity\Contabilidad\Config\ElementoGasto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ElementoGasto|null find($id, $lockMode = null, $lockVersion = null)
 * @method ElementoGasto|null findOneBy(array $criteria, array $orderBy = null)
 * @method ElementoGasto[]    findAll()
 * @method ElementoGasto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElementoGastoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ElementoGasto::class);
    }

    // /**
    //  * @return ElementoGasto[] Returns an array of ElementoGasto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ElementoGasto
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
