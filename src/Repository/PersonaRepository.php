<?php

namespace App\Repository;

use App\Entity\Persona;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Persona>
 */
class PersonaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Persona::class);
    }

    /**
     * Busca personas por nombre usando LIKE para búsqueda parcial
     * @param string $nombre El nombre o parte del nombre a buscar
     * @return Persona[] Returns an array of Persona objects
     */
    public function findByNombre(?string $nombre): array
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->orderBy('p.id', 'ASC');
        
        if ($nombre) {
            $queryBuilder
                ->andWhere('LOWER(p.nombre) LIKE LOWER(:nombre)')
                ->setParameter('nombre', '%' . $nombre . '%');
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
