<?php

namespace App\Repository\Contabilidad\Inventario;

use App\Entity\Contabilidad\Inventario\EntradaMercancia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EntradaMercancia|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntradaMercancia|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntradaMercancia[]    findAll()
 * @method EntradaMercancia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntradaMercanciaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntradaMercancia::class);
    }

    // /**
    //  * @return EntradaMercancia[] Returns an array of EntradaMercancia objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EntradaMercancia
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
