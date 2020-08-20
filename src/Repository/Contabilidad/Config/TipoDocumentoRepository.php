<?php

namespace App\Repository\Contabilidad\Config;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Config\TipoDocumento;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method TipoDocumento|null find($id, $paranoid = true)
 * @method TipoDocumento|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method TipoDocumento[]    findAll($paranoid = true)
 * @method TipoDocumento[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoDocumentoRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(TipoDocumento::class);
        $this->setRegistry($registry);
        parent::__construct();
    }

    // /**
    //  * @return TipoDocumento[] Returns an array of TipoDocumento objects
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
    public function findOneBySomeField($value): ?TipoDocumento
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
