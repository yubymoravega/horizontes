<?php

namespace App\Repository\RemesasModule\Configuracion;

use App\Entity\RemesasModule\Configuracion\BeneficiariosClientes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BeneficiariosClientes|null find($id, $lockMode = null, $lockVersion = null)
 * @method BeneficiariosClientes|null findOneBy(array $criteria, array $orderBy = null)
 * @method BeneficiariosClientes[]    findAll()
 * @method BeneficiariosClientes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeneficiariosClientesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BeneficiariosClientes::class);
    }

    // /**
    //  * @return BeneficiariosClientes[] Returns an array of BeneficiariosClientes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BeneficiariosClientes
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
