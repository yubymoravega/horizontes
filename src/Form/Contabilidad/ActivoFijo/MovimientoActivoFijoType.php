<?php

namespace App\Form\Contabilidad\ActivoFijo;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovimientoActivoFijoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', TextType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Fecha',
                'required' => false,
                'disabled' => true
            ))
            ->add('fundamentacion', TextareaType::class, [
                'label' => 'Fundamentación de la Operación',
                'attr' => ['class' => 'w-100']
            ])
            ->add('nro_inventatio', TextType::class, [
                'label' => 'Nro. Inventario',
                'attr' => ['class' => 'w-100']
            ])
            ->add('descripcion', TextType::class, [
                'label' => 'Descripción',
                'attr' => ['class' => 'w-100']
            ])
            ->add('id_cuenta', TextType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Cuenta',
                'required' => false,
                'disabled' => true
            ))
            ->add('centro_costo', TextType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Centro de Costo',
                'required' => false,
                'disabled' => true
            ))
            ->add('area_responsabilidad', TextType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Area de Responsabilidad',
                'required' => false,
                'disabled' => true
            ))
            ->add('id_movimiento', HiddenType::class)
            ->add('id_activo', HiddenType::class)
            ->add('id_subcuenta', TextType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Subcuenta',
                'required' => false,
                'disabled' => true
            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
//        $resolver->setDefaults([
//            'data_class' => MovimientoActivoFijo::class,
//        ]);
    }
}
