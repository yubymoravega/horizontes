<?php

namespace App\Repository\Contabilidad\Config;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Config\ConfiguracionInicial;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method ConfiguracionInicial|null find($id, $paranoid = true)
 * @method ConfiguracionInicial|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method ConfiguracionInicial[]    findAll($paranoid = true)
 * @method ConfiguracionInicial[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfiguracionInicialRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(ConfiguracionInicial::class);
        $this->setRegistry($registry);
        parent::__construct();
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