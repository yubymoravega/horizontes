<?php

namespace App\Repository\TurismoModule\Traslado;

use App\Entity\TurismoModule\Traslado\TipoVehiculo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoVehiculo|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoVehiculo|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoVehiculo[]    findAll()
 * @method TipoVehiculo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoVehiculoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoVehiculo::class);
    }

    // /**
    //  * @return TipoVehiculo[] Returns an array of TipoVehiculo objects
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
    public function findOneBySomeField($value): ?TipoVehiculo
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
