<?php

namespace App\Repository\Contabilidad\Config;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Config\TipoDocumentoActivoFijo;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method TipoDocumentoActivoFijo|null find($id, $paranoid = true)
 * @method TipoDocumentoActivoFijo|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method TipoDocumentoActivoFijo[]    findAll($paranoid = true)
 * @method TipoDocumentoActivoFijo[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoDocumentoActivoFijoRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(TipoDocumentoActivoFijo::class);
        $this->setRegistry($registry);
        parent::__construct();
    }

    // /**
    //  * @return TipoDocumentoActivoFijo[] Returns an array of TipoDocumentoActivoFijo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TipoDocumentoActivoFijo
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
