<?php

namespace App\Entity;

use App\Repository\ClimaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClimaRepository::class)]
class Clima
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private ?string $descripcion = null;

    /**
     * @var Collection<int, Siniestro>
     */
    #[ORM\OneToMany(targetEntity: Siniestro::class, mappedBy: 'clima')]
    private Collection $siniestros;

    public function __construct()
    {
        $this->siniestros = new ArrayCollection();
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
     * @return Collection<int, Siniestro>
     */
    public function getSiniestros(): Collection
    {
        return $this->siniestros;
    }

    public function addSiniestro(Siniestro $siniestro): static
    {
        if (!$this->siniestros->contains($siniestro)) {
            $this->siniestros->add($siniestro);
            $siniestro->setClima($this);
        }

        return $this;
    }

    public function removeSiniestro(Siniestro $siniestro): static
    {
        if ($this->siniestros->removeElement($siniestro)) {
            // set the owning side to null (unless already changed)
            if ($siniestro->getClima() === $this) {
                $siniestro->setClima(null);
            }
        }

        return $this;
    }
}
