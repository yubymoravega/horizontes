<?php

namespace App\Repository\Contabilidad\Config;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Config\CentroCosto;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method CentroCosto|null find($id, $paranoid = true)
 * @method CentroCosto|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method CentroCosto[]    findAll($paranoid = true)
 * @method CentroCosto[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class CentroCostoRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(CentroCosto::class);
        $this->setRegistry($registry);
        parent::__construct();
    }

    // /**
    //  * @return CentroCosto[] Returns an array of CentroCosto objects
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
    public function findOneBySomeField($value): ?CentroCosto
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
