<?php

namespace App\Repository\Contabilidad\Config;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Config\TipoMovimiento;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method TipoMovimiento|null find($id, $paranoid = true)
 * @method TipoMovimiento|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method TipoMovimiento[]    findAll($paranoid = true)
 * @method TipoMovimiento[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoMovimientoRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(TipoMovimiento::class);
        $this->setRegistry($registry);
        parent::__construct();
    }

    // /**
    //  * @return TipoMovimiento[] Returns an array of TipoMovimiento objects
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
    public function findOneBySomeField($value): ?TipoMovimiento
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
