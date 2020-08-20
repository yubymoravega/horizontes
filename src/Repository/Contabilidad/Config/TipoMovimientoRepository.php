<?php

namespace App\Repository\Contabilidad\Config;

use App\Entity\Contabilidad\Config\TipoMovimiento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoMovimiento|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoMovimiento|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoMovimiento[]    findAll()
 * @method TipoMovimiento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoMovimientoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoMovimiento::class);
    }

    // /**
    //  * @return TipoMovimiento[] Returns an array of TipoMovimiento objects
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
    public function findOneBySomeField($value): ?TipoMovimiento
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
