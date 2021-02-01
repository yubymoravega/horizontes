<?php

namespace App\Form\TurismoModule\Visado;

use App\Entity\TurismoModule\Visado\Solicitud;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SolicitudType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Nombre',
            ])
            ->add('primer_apellido',TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Primer apellido',
            ])
            ->add('segundo_apellido',TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Segundo apellido',
            ])
            ->add('telefono_fijo',TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Teléfono fijo',
            ])
            ->add('telefono_celular',TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Teléfono celular',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Solicitud::class,
        ]);
    }
}
