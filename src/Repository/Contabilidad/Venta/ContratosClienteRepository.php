<?php

namespace App\Repository\Contabilidad\Venta;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Venta\ContratosCliente;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method ContratosCliente|null find($id, $paranoid = true)
 * @method ContratosCliente|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method ContratosCliente[]    findAll($paranoid = true)
 * @method ContratosCliente[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratosClienteRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(ContratosCliente::class);
        $this->setRegistry($registry);
        parent::__construct();
    }
    // /**
    //  * @return ContratosCliente[] Returns an array of ContratosCliente objects
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
    public function findOneBySomeField($value): ?ContratosCliente
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
