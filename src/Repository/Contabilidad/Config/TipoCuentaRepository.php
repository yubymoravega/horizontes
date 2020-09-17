<?php

namespace App\Repository\Contabilidad\Config;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Config\TipoCuenta;

;

use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoCuenta|null find($id, $paranoid = true)
 * @method TipoCuenta|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method TipoCuenta[]    findAll($paranoid = true)
 * @method TipoCuenta[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoCuentaRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(TipoCuenta::class);
        $this->setRegistry($registry);
        parent::__construct();
    }

    // /**
    //  * @return TipoCuenta[] Returns an array of TipoCuenta objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TipoCuenta
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
