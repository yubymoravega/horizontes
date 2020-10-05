<?php

namespace App\Repository\Contabilidad\Venta;

use App\Entity\Contabilidad\Venta\ContratosCliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContratosCliente|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContratosCliente|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContratosCliente[]    findAll()
 * @method ContratosCliente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratosClienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContratosCliente::class);
    }

    // /**
    //  * @return ContratosCliente[] Returns an array of ContratosCliente objects
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
    public function findOneBySomeField($value): ?ContratosCliente
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
