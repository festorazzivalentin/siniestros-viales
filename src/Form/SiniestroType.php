<?php

namespace App\Form;

use App\Entity\Clima;
use App\Entity\Siniestro;
use App\Entity\SiniestroDetalle;
use App\Form\SiniestroDetalleType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class SiniestroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Fecha del Siniestro',
                'required' => true
            ])
            ->add('hora', TimeType::class, [
                'widget' => 'choice',
                'input' => 'datetime',
                'label' => 'Hora del Siniestro',
                'required' => true
            ])
            ->add('ubicacion', TextType::class, [
                'label' => 'Ubicación del Siniestro',
                'required' => true
            ])
            ->add('descripcion', TextType::class, [
                'label' => 'Descripción del Siniestro',
                'required' => true
            ])
            ->add('clima', EntityType::class, [
                'class' => Clima::class,
                'choice_label' => 'descripcion',
            ])
            ->add('siniestroDetalles', CollectionType::class, [
                'entry_type' => SiniestroDetalleType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Detalles del Siniestro',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Siniestro::class,
        ]);
    }
}
