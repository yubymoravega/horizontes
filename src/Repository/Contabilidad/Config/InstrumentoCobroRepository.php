<?php

namespace App\Repository\Contabilidad\Config;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Config\InstrumentoCobro;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method InstrumentoCobro|null find($id, $paranoid = true)
 * @method InstrumentoCobro|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method InstrumentoCobro[]    findAll($paranoid = true)
 * @method InstrumentoCobro[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class InstrumentoCobroRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(InstrumentoCobro::class);
        $this->setRegistry($registry);
        parent::__construct();
    }

    // /**
    //  * @return InstrumentoCobro[] Returns an array of InstrumentoCobro objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InstrumentoCobro
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
