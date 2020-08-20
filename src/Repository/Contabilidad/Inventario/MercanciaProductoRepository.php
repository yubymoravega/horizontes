<?php

namespace App\Repository\Contabilidad\Inventario;

use App\Entity\Contabilidad\Inventario\MercanciaProducto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MercanciaProducto|null find($id, $lockMode = null, $lockVersion = null)
 * @method MercanciaProducto|null findOneBy(array $criteria, array $orderBy = null)
 * @method MercanciaProducto[]    findAll()
 * @method MercanciaProducto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MercanciaProductoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MercanciaProducto::class);
    }

    // /**
    //  * @return MercanciaProducto[] Returns an array of MercanciaProducto objects
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
    public function findOneBySomeField($value): ?MercanciaProducto
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
