<?php

namespace App\Repository;

use App\Entity\Siniestro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Siniestro>
 */
class SiniestroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Siniestro::class);
    }

    /**
     * Buscar siniestros por fecha (igualdad de fecha) o listar todos si no se pasa fecha.
     * @param string|null $fecha Fecha en formato 'YYYY-MM-DD'
     * @return Siniestro[]
     */
    public function findByFecha(?string $fecha): array
    {
        $qb = $this->createQueryBuilder('s')
            ->orderBy('s.fecha', 'DESC');

        if ($fecha) {
            try {
                $date = new \DateTime($fecha);
                // Comparar por fecha (sin hora)
                $qb->andWhere('s.fecha = :fecha')
                   ->setParameter('fecha', $date->format('Y-m-d'));
            } catch (\Exception $e) {
                // Si no se puede parsear la fecha, no filtrar
            }
        }

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Siniestro[] Returns an array of Siniestro objects
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

    //    public function findOneBySomeField($value): ?Siniestro
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
