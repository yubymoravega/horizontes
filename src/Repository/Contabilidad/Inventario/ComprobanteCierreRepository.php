<?php

namespace App\Repository\Contabilidad\Inventario;

use App\Entity\Contabilidad\Inventario\ComprobanteCierre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ComprobanteCierre|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComprobanteCierre|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComprobanteCierre[]    findAll()
 * @method ComprobanteCierre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComprobanteCierreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComprobanteCierre::class);
    }

    // /**
    //  * @return ComprobanteCierre[] Returns an array of ComprobanteCierre objects
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
    public function findOneBySomeField($value): ?ComprobanteCierre
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
