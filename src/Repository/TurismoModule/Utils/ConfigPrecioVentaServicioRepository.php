<?php

namespace App\Repository\TurismoModule\Utils;

use App\Entity\TurismoModule\Utils\ConfigPrecioVentaServicio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConfigPrecioVentaServicio|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfigPrecioVentaServicio|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfigPrecioVentaServicio[]    findAll()
 * @method ConfigPrecioVentaServicio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfigPrecioVentaServicioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConfigPrecioVentaServicio::class);
    }

    // /**
    //  * @return ConfigPrecioVentaServicio[] Returns an array of ConfigPrecioVentaServicio objects
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
    public function findOneBySomeField($value): ?ConfigPrecioVentaServicio
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
