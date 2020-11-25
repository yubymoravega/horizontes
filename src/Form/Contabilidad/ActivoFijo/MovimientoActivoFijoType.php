<?php

namespace App\Form\Contabilidad\ActivoFijo;

use App\Entity\Contabilidad\ActivoFijo\MovimientoActivoFijo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovimientoActivoFijoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha',DateType::class, array(
                'input'=>'datetime',
                'widget'=>'single_text',
                'placeholder'=>'Fecha',

            ))
            ->add('fundamentacion',TextareaType::class, [
                'label' => 'Fundamentación de la Operación',
                'attr' => ['class' => 'w-100']
            ])
            ->add('nro_inventatio',TextType::class, [
                'label' => 'Nro. Inventario',
                'attr' => ['class' => 'w-100']
            ])
            ->add('descripcion',TextType::class, [
                'label' => 'Descripción',
                'attr' => ['class' => 'w-100']
            ])
            ->add('id_cuenta',ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label'=>'Cuenta',
                'choice_label' => 'nro_cuenta',
            ))
            ->add('id_subcuenta',ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label'=>'Subcuenta',
                'choice_label' => 'nro_subcuenta',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
//        $resolver->setDefaults([
//            'data_class' => MovimientoActivoFijo::class,
//        ]);
    }
}
