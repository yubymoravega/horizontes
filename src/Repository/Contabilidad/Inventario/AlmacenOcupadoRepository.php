<?php

namespace App\Repository\Contabilidad\Inventario;

use App\Entity\Contabilidad\Inventario\AlmacenOcupado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AlmacenOcupado|null find($id, $lockMode = null, $lockVersion = null)
 * @method AlmacenOcupado|null findOneBy(array $criteria, array $orderBy = null)
 * @method AlmacenOcupado[]    findAll()
 * @method AlmacenOcupado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlmacenOcupadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlmacenOcupado::class);
    }

    // /**
    //  * @return AlmacenOcupado[] Returns an array of AlmacenOcupado objects
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
    public function findOneBySomeField($value): ?AlmacenOcupado
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
