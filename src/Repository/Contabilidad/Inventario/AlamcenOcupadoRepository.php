<?php

namespace App\Repository\Contabilidad\Inventario;

use App\Entity\Contabilidad\Inventario\AlamcenOcupado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AlamcenOcupado|null find($id, $lockMode = null, $lockVersion = null)
 * @method AlamcenOcupado|null findOneBy(array $criteria, array $orderBy = null)
 * @method AlamcenOcupado[]    findAll()
 * @method AlamcenOcupado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlamcenOcupadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlamcenOcupado::class);
    }

    // /**
    //  * @return AlamcenOcupado[] Returns an array of AlamcenOcupado objects
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
    public function findOneBySomeField($value): ?AlamcenOcupado
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
