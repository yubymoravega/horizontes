<?php

namespace App\Form\TurismoModule\Traslado;

use App\Entity\TurismoModule\Traslado\Aeropuerto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AeropuertoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class,[
                'required' => true,
                'attr' => ['class' => 'w-100'],
                'label' => 'Nombre',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Aeropuerto::class,
        ]);
    }
}
