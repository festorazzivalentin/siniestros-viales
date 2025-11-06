<?php

namespace App\Entity;

use App\Repository\PersonaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonaRepository::class)]
class Persona
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $fecha_nacimiento = null;

    #[ORM\Column]
    private ?int $dni = null;

    #[ORM\ManyToOne(inversedBy: 'personas')]
    private ?Sexo $sexo = null;

    /**
     * @var Collection<int, SiniestroDetalle>
     */
    #[ORM\OneToMany(targetEntity: SiniestroDetalle::class, mappedBy: 'persona')]
    private Collection $siniestroDetalles;

    public function __construct()
    {
        $this->siniestroDetalles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTime
    {
        return $this->fecha_nacimiento;
    }

    public function setFechaNacimiento(\DateTime $fecha_nacimiento): static
    {
        $this->fecha_nacimiento = $fecha_nacimiento;

        return $this;
    }

    public function getDni(): ?int
    {
        return $this->dni;
    }

    public function setDni(int $dni): static
    {
        $this->dni = $dni;

        return $this;
    }

    public function getSexo(): ?Sexo
    {
        return $this->sexo;
    }

    public function setSexo(?Sexo $sexo): static
    {
        $this->sexo = $sexo;

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
            $siniestroDetalle->setPersona($this);
        }

        return $this;
    }

    public function removeSiniestroDetalle(SiniestroDetalle $siniestroDetalle): static
    {
        if ($this->siniestroDetalles->removeElement($siniestroDetalle)) {
            // set the owning side to null (unless already changed)
            if ($siniestroDetalle->getPersona() === $this) {
                $siniestroDetalle->setPersona(null);
            }
        }

        return $this;
    }
}
