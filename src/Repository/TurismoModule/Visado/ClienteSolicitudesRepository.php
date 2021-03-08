<?php

namespace App\Repository\TurismoModule\Visado;

use App\Entity\TurismoModule\Visado\ClienteSolicitudes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClienteSolicitudes|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClienteSolicitudes|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClienteSolicitudes[]    findAll()
 * @method ClienteSolicitudes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClienteSolicitudesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClienteSolicitudes::class);
    }

    // /**
    //  * @return ClienteSolicitudes[] Returns an array of ClienteSolicitudes objects
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
    public function findOneBySomeField($value): ?ClienteSolicitudes
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
