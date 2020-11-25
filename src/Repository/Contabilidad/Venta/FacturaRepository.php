<?php

namespace App\Repository\Contabilidad\Venta;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Venta\Factura;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method Factura|null find($id, $paranoid = true)
 * @method Factura|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method Factura[]    findAll($paranoid = true)
 * @method Factura[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class FacturaRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(Factura::class);
        $this->setRegistry($registry);
        parent::__construct();
    }
    public function generateNroFactura($unidad)
    {
        $cantidad = $this->count(['anno' => \Date('Y'), 'id_unidad' => $unidad]);
        return $cantidad + 1;
    }

    // /**
    //  * @return Factura[] Returns an array of Factura objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Factura
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
