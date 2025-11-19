<?php

namespace App\Repository;

use App\Entity\SiniestroDetalle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SiniestroDetalle>
 */
class SiniestroDetalleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SiniestroDetalle::class);
    }

    public function contarPorTipoVehiculo(): array {
        return $this->createQueryBuilder('sd')
            ->select('tv.descripcion AS tipo, COUNT(sd.id) AS cantidad')
            ->join('sd.tipo_vehiculo', 'tv')
            ->groupBy('tv.descripcion')
            ->getQuery()
            ->getArrayResult();
    }

    public function contarVictimaAutor(): array {
        return $this->createQueryBuilder('d')
        ->select('r.descripcion AS rol, COUNT(d.id) AS cantidad')
        ->join('d.rol', 'r')
        ->where('r.id IN (:ids)')
        ->setParameter('ids', [1, 2])
        ->groupBy('r.descripcion')
        ->getQuery()
        ->getResult();
    }

    //    /**
    //     * @return SiniestroDetalle[] Returns an array of SiniestroDetalle objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SiniestroDetalle
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
