<?php

namespace App\Repository\Contabilidad\Config;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Config\Cuenta;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method Cuenta|null find($id, $paranoid = true)
 * @method Cuenta|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method Cuenta[]    findAll($paranoid = true)
 * @method Cuenta[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class CuentaRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(Cuenta::class);
        $this->setRegistry($registry);
        parent::__construct();
    }

    // /**
    //  * @return Cuenta[] Returns an array of Cuenta objects
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
    public function findOneBySomeField($value): ?Cuenta
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
