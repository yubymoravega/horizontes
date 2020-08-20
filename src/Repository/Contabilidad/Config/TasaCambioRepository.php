<?php

namespace App\Repository\Contabilidad\Config;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Config\TasaCambio;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method TasaCambio|null find($id, $paranoid = true)
 * @method TasaCambio|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method TasaCambio[]    findAll($paranoid = true)
 * @method TasaCambio[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class TasaCambioRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(TasaCambio::class);
        $this->setRegistry($registry);
        parent::__construct();
    }

    // /**
    //  * @return TasaCambio[] Returns an array of TasaCambio objects
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
    public function findOneBySomeField($value): ?TasaCambio
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
