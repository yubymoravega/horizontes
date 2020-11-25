<?php

namespace App\Repository\Contabilidad\Venta;

use App\Entity\Contabilidad\Venta\CuentasCliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CuentasCliente|null find($id, $lockMode = null, $lockVersion = null)
 * @method CuentasCliente|null findOneBy(array $criteria, array $orderBy = null)
 * @method CuentasCliente[]    findAll()
 * @method CuentasCliente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CuentasClienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CuentasCliente::class);
    }

    // /**
    //  * @return CuentasCliente[] Returns an array of CuentasCliente objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CuentasCliente
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
