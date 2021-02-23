<?php

namespace App\Repository\RemesasModule\Configuracion;

use App\Entity\RemesasModule\Configuracion\ConfiguracionReglasRemesas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConfiguracionReglasRemesas|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfiguracionReglasRemesas|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfiguracionReglasRemesas[]    findAll()
 * @method ConfiguracionReglasRemesas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfiguracionReglasRemesasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConfiguracionReglasRemesas::class);
    }

    // /**
    //  * @return ConfiguracionReglasRemesas[] Returns an array of ConfiguracionReglasRemesas objects
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
    public function findOneBySomeField($value): ?ConfiguracionReglasRemesas
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
