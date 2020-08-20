<?php

namespace App\Repository\Contabilidad\Inventario;

use App\Entity\Contabilidad\Inventario\Transferencia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Transferencia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transferencia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transferencia[]    findAll()
 * @method Transferencia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransferenciaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transferencia::class);
    }

    // /**
    //  * @return Transferencia[] Returns an array of Transferencia objects
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
    public function findOneBySomeField($value): ?Transferencia
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
