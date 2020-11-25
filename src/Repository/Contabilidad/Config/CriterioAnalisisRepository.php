<?php

namespace App\Repository\Contabilidad\Config;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Config\CriterioAnalisis;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method CriterioAnalisis|null find($id, $paranoid = true)
 * @method CriterioAnalisis|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method CriterioAnalisis[]    findAll($paranoid = true)
 * @method CriterioAnalisis[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class CriterioAnalisisRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(CriterioAnalisis::class);
        $this->setRegistry($registry);
        parent::__construct();
    }

    // /**
    //  * @return CriterioAnalisis[] Returns an array of CriterioAnalisis objects
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
    public function findOneBySomeField($value): ?CriterioAnalisis
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
