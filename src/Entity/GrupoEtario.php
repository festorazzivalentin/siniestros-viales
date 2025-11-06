<?php

namespace App\Entity;

use App\Repository\GrupoEtarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GrupoEtarioRepository::class)]
class GrupoEtario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    /**
     * @var Collection<int, SiniestroDetalle>
     */
    #[ORM\OneToMany(targetEntity: SiniestroDetalle::class, mappedBy: 'grupo_etario')]
    private Collection $siniestroDetalles;

    public function __construct()
    {
        $this->siniestroDetalles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection<int, SiniestroDetalle>
     */
    public function getSiniestroDetalles(): Collection
    {
        return $this->siniestroDetalles;
    }

    public function addSiniestroDetalle(SiniestroDetalle $siniestroDetalle): static
    {
        if (!$this->siniestroDetalles->contains($siniestroDetalle)) {
            $this->siniestroDetalles->add($siniestroDetalle);
            $siniestroDetalle->setGrupoEtario($this);
        }

        return $this;
    }

    public function removeSiniestroDetalle(SiniestroDetalle $siniestroDetalle): static
    {
        if ($this->siniestroDetalles->removeElement($siniestroDetalle)) {
            // set the owning side to null (unless already changed)
            if ($siniestroDetalle->getGrupoEtario() === $this) {
                $siniestroDetalle->setGrupoEtario(null);
            }
        }

        return $this;
    }
}
