<?php

namespace App\Form;

use App\Entity\EstadoAlcoholico;
use App\Entity\EstadoCivil;
use App\Entity\GrupoEtario;
use App\Entity\Persona;
use App\Entity\Rol;
use App\Entity\Siniestro;
use App\Entity\SiniestroDetalle;
use App\Entity\TipoVehiculo;
use Dom\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class SiniestroDetalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('edad', IntegerType::class)
            ->add('porcentaje_alcohol', NumberType::class, [
                'scale' => 2,
                'required' => true,
                'label' => 'Porcentaje de alcohol'
            ])
            ->add('vehiculo_modelo', TextType::class, [
                'label' => 'Modelo de vehículo',
                'required' => true
            ])
            ->add('vehiculo_patente', TextType::class, [
                'label' => 'Patente de vehículo',
                'required' => true
            ])
            ->add('observaciones', TextType::class, [
                'label' => 'Observaciones',
                'required' => false
            ])
            // ->add('siniestro', EntityType::class, [
            //     'class' => Siniestro::class,
            //     'choice_label' => 'id', // Es necesario registrar esto?
            // ])
            ->add('persona', EntityType::class, [
                'class' => Persona::class,
                'choice_label' => 'dni',
            ])
            ->add('rol', EntityType::class, [
                'class' => Rol::class,
                'choice_label' => 'descripcion',
            ])
            ->add('tipo_vehiculo', EntityType::class, [
                'class' => TipoVehiculo::class,
                'choice_label' => 'descripcion',
            ])
            ->add('grupo_etario', EntityType::class, [
                'class' => GrupoEtario::class,
                'choice_label' => 'descripcion',
            ])
            ->add('estado_civil', EntityType::class, [
                'class' => EstadoCivil::class,
                'choice_label' => 'descripcion',
            ])
            ->add('estado_alcoholico', EntityType::class, [
                'class' => EstadoAlcoholico::class,
                'choice_label' => 'descripcion',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SiniestroDetalle::class,
        ]);
    }
}
