<?php

namespace App\Repository\Contabilidad\CapitalHumano;

use App\Entity\Contabilidad\CapitalHumano\VacacionesDisfrutadas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VacacionesDisfrutadas|null find($id, $lockMode = null, $lockVersion = null)
 * @method VacacionesDisfrutadas|null findOneBy(array $criteria, array $orderBy = null)
 * @method VacacionesDisfrutadas[]    findAll()
 * @method VacacionesDisfrutadas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VacacionesDisfrutadasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VacacionesDisfrutadas::class);
    }

    // /**
    //  * @return VacacionesDisfrutadas[] Returns an array of VacacionesDisfrutadas objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VacacionesDisfrutadas
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
