<?php

namespace App\Repository\TurismoModule\Traslado;

use App\Entity\TurismoModule\Traslado\PrecioVenta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PrecioVenta|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrecioVenta|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrecioVenta[]    findAll()
 * @method PrecioVenta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrecioVentaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrecioVenta::class);
    }

    // /**
    //  * @return PrecioVenta[] Returns an array of PrecioVenta objects
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
    public function findOneBySomeField($value): ?PrecioVenta
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
