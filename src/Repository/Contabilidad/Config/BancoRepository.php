<?php

namespace App\Repository\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Banco;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Banco|null find($id, $lockMode = null, $lockVersion = null)
 * @method Banco|null findOneBy(array $criteria, array $orderBy = null)
 * @method Banco[]    findAll()
 * @method Banco[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BancoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Banco::class);
    }

    // /**
    //  * @return Banco[] Returns an array of Banco objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Banco
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
