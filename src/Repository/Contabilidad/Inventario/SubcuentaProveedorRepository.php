<?php

namespace App\Repository\Contabilidad\Inventario;

use App\Entity\Contabilidad\Inventario\SubcuentaProveedor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubcuentaProveedor|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubcuentaProveedor|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubcuentaProveedor[]    findAll()
 * @method SubcuentaProveedor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubcuentaProveedorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubcuentaProveedor::class);
    }

    // /**
    //  * @return SubcuentaProveedor[] Returns an array of SubcuentaProveedor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubcuentaProveedor
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
