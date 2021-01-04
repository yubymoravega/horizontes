<?php

namespace App\Repository\Contabilidad\ActivoFijo;

use App\Entity\Contabilidad\ActivoFijo\ActivoFijo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ActivoFijo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActivoFijo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActivoFijo[]    findAll()
 * @method ActivoFijo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivoFijoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivoFijo::class);
    }

    public function findByUnidadGroupByCuentaSubCuenta($unidad)
    {
        return $this->createQueryBuilder()
//            ->where('a.id_unidad = :unidad')
//            ->join('a.id_unidad','id_unidad')
            ->select('a', 'u')
            ->from('App:Contabilidad\ActivoFijo\ActivoFijo','a')
            ->innerJoin('a.id_unidad', 'u')
            ->andWhere('a.activo = true')
            ->setParameter('unidad', $unidad)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return ActivoFijo[] Returns an array of ActivoFijo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ActivoFijo
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
