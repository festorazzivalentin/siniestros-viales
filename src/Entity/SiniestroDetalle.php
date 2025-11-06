<?php

namespace App\Entity;

use App\Repository\SiniestroDetalleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiniestroDetalleRepository::class)]
class SiniestroDetalle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'siniestroDetalles')]
    private ?Siniestro $siniestro = null;

    #[ORM\ManyToOne(inversedBy: 'siniestroDetalles')]
    private ?Persona $persona = null;

    #[ORM\ManyToOne(inversedBy: 'siniestroDetalles')]
    private ?Rol $rol = null;

    #[ORM\ManyToOne(inversedBy: 'siniestroDetalles')]
    private ?TipoVehiculo $tipo_vehiculo = null;

    #[ORM\ManyToOne(inversedBy: 'siniestroDetalles')]
    private ?GrupoEtario $grupo_etario = null;

    #[ORM\ManyToOne(inversedBy: 'siniestroDetalles')]
    private ?EstadoCivil $estado_civil = null;

    #[ORM\Column]
    private ?int $edad = null;

    #[ORM\ManyToOne(inversedBy: 'siniestroDetalles')]
    private ?EstadoAlcoholico $estado_alcoholico = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $porcentaje_alcohol = null;

    #[ORM\Column(length: 255)]
    private ?string $vehiculo_modelo = null;

    #[ORM\Column(length: 255)]
    private ?string $vehiculo_patente = null;

    #[ORM\Column(length: 255)]
    private ?string $observaciones = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiniestro(): ?Siniestro
    {
        return $this->siniestro;
    }

    public function setSiniestro(?Siniestro $siniestro): static
    {
        $this->siniestro = $siniestro;

        return $this;
    }

    public function getPersona(): ?Persona
    {
        return $this->persona;
    }

    public function setPersona(?Persona $persona): static
    {
        $this->persona = $persona;

        return $this;
    }

    public function getRol(): ?Rol
    {
        return $this->rol;
    }

    public function setRol(?Rol $rol): static
    {
        $this->rol = $rol;

        return $this;
    }

    public function getTipoVehiculo(): ?TipoVehiculo
    {
        return $this->tipo_vehiculo;
    }

    public function setTipoVehiculo(?TipoVehiculo $tipo_vehiculo): static
    {
        $this->tipo_vehiculo = $tipo_vehiculo;

        return $this;
    }

    public function getGrupoEtario(): ?GrupoEtario
    {
        return $this->grupo_etario;
    }

    public function setGrupoEtario(?GrupoEtario $grupo_etario): static
    {
        $this->grupo_etario = $grupo_etario;

        return $this;
    }

    public function getEstadoCivil(): ?EstadoCivil
    {
        return $this->estado_civil;
    }

    public function setEstadoCivil(?EstadoCivil $estado_civil): static
    {
        $this->estado_civil = $estado_civil;

        return $this;
    }

    public function getEdad(): ?int
    {
        return $this->edad;
    }

    public function setEdad(int $edad): static
    {
        $this->edad = $edad;

        return $this;
    }

    public function getEstadoAlcoholico(): ?EstadoAlcoholico
    {
        return $this->estado_alcoholico;
    }

    public function setEstadoAlcoholico(?EstadoAlcoholico $estado_alcoholico): static
    {
        $this->estado_alcoholico = $estado_alcoholico;

        return $this;
    }

    public function getPorcentajeAlcohol(): ?string
    {
        return $this->porcentaje_alcohol;
    }

    public function setPorcentajeAlcohol(string $porcentaje_alcohol): static
    {
        $this->porcentaje_alcohol = $porcentaje_alcohol;

        return $this;
    }

    public function getVehiculoModelo(): ?string
    {
        return $this->vehiculo_modelo;
    }

    public function setVehiculoModelo(string $vehiculo_modelo): static
    {
        $this->vehiculo_modelo = $vehiculo_modelo;

        return $this;
    }

    public function getVehiculoPatente(): ?string
    {
        return $this->vehiculo_patente;
    }

    public function setVehiculoPatente(string $vehiculo_patente): static
    {
        $this->vehiculo_patente = $vehiculo_patente;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(string $observaciones): static
    {
        $this->observaciones = $observaciones;

        return $this;
    }
}
