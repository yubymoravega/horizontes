<?php

namespace App\Repository\Contabilidad\CapitalHumano;

use App\Entity\Contabilidad\CapitalHumano\NominaTerceroComprobante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NominaTerceroComprobante|null find($id, $lockMode = null, $lockVersion = null)
 * @method NominaTerceroComprobante|null findOneBy(array $criteria, array $orderBy = null)
 * @method NominaTerceroComprobante[]    findAll()
 * @method NominaTerceroComprobante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NominaTerceroComprobanteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NominaTerceroComprobante::class);
    }

    // /**
    //  * @return NominaTerceroComprobante[] Returns an array of NominaTerceroComprobante objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NominaTerceroComprobante
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
