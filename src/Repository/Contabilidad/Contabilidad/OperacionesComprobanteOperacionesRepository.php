<?php

namespace App\Repository\Contabilidad\Contabilidad;

use App\Entity\Contabilidad\Contabilidad\OperacionesComprobanteOperaciones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OperacionesComprobanteOperaciones|null find($id, $lockMode = null, $lockVersion = null)
 * @method OperacionesComprobanteOperaciones|null findOneBy(array $criteria, array $orderBy = null)
 * @method OperacionesComprobanteOperaciones[]    findAll()
 * @method OperacionesComprobanteOperaciones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperacionesComprobanteOperacionesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperacionesComprobanteOperaciones::class);
    }

    // /**
    //  * @return OperacionesComprobanteOperaciones[] Returns an array of OperacionesComprobanteOperaciones objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OperacionesComprobanteOperaciones
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
