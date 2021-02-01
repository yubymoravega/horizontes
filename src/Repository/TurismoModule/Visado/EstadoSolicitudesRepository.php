<?php

namespace App\Repository\TurismoModule\Visado;

use App\Entity\TurismoModule\Visado\EstadoSolicitudes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EstadoSolicitudes|null find($id, $lockMode = null, $lockVersion = null)
 * @method EstadoSolicitudes|null findOneBy(array $criteria, array $orderBy = null)
 * @method EstadoSolicitudes[]    findAll()
 * @method EstadoSolicitudes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstadoSolicitudesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EstadoSolicitudes::class);
    }

    // /**
    //  * @return EstadoSolicitudes[] Returns an array of EstadoSolicitudes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EstadoSolicitudes
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
