<?php

namespace App\Form\Contabilidad\ActivoFijo;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivoFijoCuentasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_cuenta_activo', ChoiceType::class,[
                'label'=>'Cuenta del Activo'
            ])
            ->add('id_subcuenta_activo', ChoiceType::class,[
                'label'=>'Subcuenta del Activo'
            ])
            ->add('id_centro_costo_activo', ChoiceType::class,[
                'label'=>'Centro de Costo'
            ])
            ->add('id_area_responsabilidad_activo', ChoiceType::class,[
                'label'=>'Area de Responsabilidad'
            ])
            ->add('id_cuenta_depreciacion',ChoiceType::class,[
                'label'=>'Cuenta de Depreciación'
            ])
            ->add('id_subcuenta_depreciacion',ChoiceType::class,[
                'label'=>'Subcuenta de Depresiación'
            ])
            ->add('id_cuenta_gasto',ChoiceType::class,[
                'label'=>'Cuenta de Gasto'
            ])
            ->add('id_subcuenta_gasto',ChoiceType::class,[
                'label'=>'Subcuenta de Gasto'
            ])
            ->add('id_centro_costo_gasto',ChoiceType::class,[
                'label'=>'Centro de Costo'
            ])
            ->add('id_elemento_gasto_gasto', ChoiceType::class,[
                'label'=>'Elemento de Gasto'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
//        $resolver->setDefaults([
//            'data_class' => ActivoFijoCuentas::class,
//        ]);
    }
}
