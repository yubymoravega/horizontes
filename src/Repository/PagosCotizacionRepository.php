<?php

namespace App\Repository;

use App\Entity\PagosCotizacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PagosCotizacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method PagosCotizacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method PagosCotizacion[]    findAll()
 * @method PagosCotizacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PagosCotizacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PagosCotizacion::class);
    }

    // /**
    //  * @return PagosCotizacion[] Returns an array of PagosCotizacion objects
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
    public function findOneBySomeField($value): ?PagosCotizacion
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
