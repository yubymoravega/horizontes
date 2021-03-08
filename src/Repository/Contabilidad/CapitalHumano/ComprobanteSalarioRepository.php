<?php

namespace App\Repository\Contabilidad\CapitalHumano;

use App\Entity\Contabilidad\CapitalHumano\ComprobanteSalario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ComprobanteSalario|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComprobanteSalario|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComprobanteSalario[]    findAll()
 * @method ComprobanteSalario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComprobanteSalarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComprobanteSalario::class);
    }

    // /**
    //  * @return ComprobanteSalario[] Returns an array of ComprobanteSalario objects
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
    public function findOneBySomeField($value): ?ComprobanteSalario
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
