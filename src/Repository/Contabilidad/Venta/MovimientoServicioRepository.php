<?php

namespace App\Repository\Contabilidad\Venta;

use App\Entity\Contabilidad\Venta\MovimientoServicio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MovimientoServicio|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovimientoServicio|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovimientoServicio[]    findAll()
 * @method MovimientoServicio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovimientoServicioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovimientoServicio::class);
    }

    // /**
    //  * @return MovimientoServicio[] Returns an array of MovimientoServicio objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MovimientoServicio
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
