<?php

namespace App\Repository\Contabilidad\Inventario;

use App\Entity\Contabilidad\Inventario\SaldoCuentas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SaldoCuentas|null find($id, $lockMode = null, $lockVersion = null)
 * @method SaldoCuentas|null findOneBy(array $criteria, array $orderBy = null)
 * @method SaldoCuentas[]    findAll()
 * @method SaldoCuentas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaldoCuentasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SaldoCuentas::class);
    }

    // /**
    //  * @return SaldoCuentas[] Returns an array of SaldoCuentas objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SaldoCuentas
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
