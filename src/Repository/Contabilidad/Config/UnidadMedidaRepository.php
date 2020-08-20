<?php

namespace App\Repository\Contabilidad\Config;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Config\UnidadMedida;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method UnidadMedida|null find($id, $paranoid = true)
 * @method UnidadMedida|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method UnidadMedida[]    findAll($paranoid = true)
 * @method UnidadMedida[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class UnidadMedidaRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(UnidadMedida::class);
        $this->setRegistry($registry);
        parent::__construct();
    }

    // /**
    //  * @return UnidadMedida[] Returns an array of UnidadMedida objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UnidadMedida
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
