<?php

namespace App\Repository\Contabilidad\Config;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Config\Modulo;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method Modulo|null find($id, $paranoid = true)
 * @method Modulo|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method Modulo[]    findAll($paranoid = true)
 * @method Modulo[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuloRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(Modulo::class);
        $this->setRegistry($registry);
        parent::__construct();
    }

    // /**
    //  * @return Modulo[] Returns an array of Modulo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Modulo
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
