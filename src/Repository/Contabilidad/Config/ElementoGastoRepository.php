<?php

namespace App\Repository\Contabilidad\Config;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Config\ElementoGasto;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method ElementoGasto|null find($id, $paranoid = true)
 * @method ElementoGasto|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method ElementoGasto[]    findAll($paranoid = true)
 * @method ElementoGasto[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class ElementoGastoRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setRegistry($registry);
        $this->setEntityClass(ElementoGasto::class);
        parent::__construct();
    }

    // /**
    //  * @return ElementoGasto[] Returns an array of ElementoGasto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ElementoGasto
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
