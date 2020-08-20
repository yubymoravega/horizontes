<?php

namespace App\Repository\Contabilidad\Config;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Config\Almacen;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method Almacen|null find($id, $paranoid = true)
 * @method Almacen|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method Almacen[]    findAll($paranoid = true)
 * @method Almacen[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class AlmacenRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(Almacen::class);
        $this->setRegistry($registry);
        parent::__construct();
    }

    // /**
    //  * @return Almacen[] Returns an array of Almacen objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Almacen
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
