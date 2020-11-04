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
            ->add('id_cuenta_activo', ChoiceType::class)
            ->add('id_subcuenta_activo', ChoiceType::class)
            ->add('id_centro_costo_activo', ChoiceType::class)
            ->add('id_area_responsabilidad_activo', ChoiceType::class)
            ->add('id_cuenta_depreciacion',ChoiceType::class)
            ->add('id_subcuenta_depreciacion',ChoiceType::class)
            ->add('id_cuenta_gasto',ChoiceType::class)
            ->add('id_subcuenta_gasto',ChoiceType::class)
            ->add('id_centro_costo_gasto',ChoiceType::class)
            ->add('id_elemento_gasto_gasto', ChoiceType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
//        $resolver->setDefaults([
//            'data_class' => ActivoFijoCuentas::class,
//        ]);
    }
}
