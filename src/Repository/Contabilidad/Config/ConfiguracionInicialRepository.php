<?php

namespace App\Repository\Contabilidad\Config;

use App\Entity\Contabilidad\Config\ConfiguracionInicial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConfiguracionInicial|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfiguracionInicial|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfiguracionInicial[]    findAll()
 * @method ConfiguracionInicial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfiguracionInicialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConfiguracionInicial::class);
    }

    // /**
    //  * @return ConfiguracionInicial[] Returns an array of ConfiguracionInicial objects
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
    public function findOneBySomeField($value): ?ConfiguracionInicial
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
