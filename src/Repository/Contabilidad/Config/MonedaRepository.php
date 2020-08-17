<?php

namespace App\Repository\Contabilidad\Config;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Config\Moneda;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method Moneda|null find($id, $paranoid = true)
 * @method Moneda|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method Moneda[]    findAll($paranoid = true)
 * @method Moneda[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class MonedaRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(Moneda::class);
        $this->setRegistry($registry);
        parent::__construct();
    }

    // /**
    //  * @return Moneda[] Returns an array of Moneda objects
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
    public function findOneBySomeField($value): ?Moneda
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
