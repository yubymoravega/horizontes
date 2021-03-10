<?php

namespace App\Repository\Contabilidad\Config;

use App\Entity\Contabilidad\Config\ConfigServicios;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConfigServicios|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfigServicios|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfigServicios[]    findAll()
 * @method ConfigServicios[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfigServiciosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConfigServicios::class);
    }

    // /**
    //  * @return ConfigServicios[] Returns an array of ConfigServicios objects
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
    public function findOneBySomeField($value): ?ConfigServicios
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
