<?php

namespace App\Repository\Contabilidad\Config;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Config\Subcuenta;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method Subcuenta|null find($id, $paranoid = true)
 * @method Subcuenta|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method Subcuenta[]    findAll($paranoid = true)
 * @method Subcuenta[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class SubcuentaRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(Subcuenta::class);
        $this->setRegistry($registry);
        parent::__construct();
    }

    // /**
    //  * @return Subcuenta[] Returns an array of Subcuenta objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Subcuenta
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
