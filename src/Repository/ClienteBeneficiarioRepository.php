<?php

namespace App\Repository;

use App\Entity\ClienteBeneficiario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClienteBeneficiario|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClienteBeneficiario|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClienteBeneficiario[]    findAll()
 * @method ClienteBeneficiario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClienteBeneficiarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClienteBeneficiario::class);
    }

    // /**
    //  * @return ClienteBeneficiario[] Returns an array of ClienteBeneficiario objects
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
    public function findOneBySomeField($value): ?ClienteBeneficiario
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
