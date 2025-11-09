<?php

namespace App\Form;

use App\Entity\Persona;
use App\Entity\Sexo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PersonaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Nombre completo',
                'required' => true
            ])
            ->add('fecha_nacimiento', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Fecha de Nacimiento',
                'required' => true
            ])
            ->add('dni', IntegerType::class, [
                'label' => 'DNI',
                'required' => true
            ])
            ->add('sexo', EntityType::class, [
                'class' => Sexo::class,
                'choice_label' => 'descripcion',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Persona::class,
        ]);
    }
}
