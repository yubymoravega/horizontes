<?php

namespace App\Form\Contabilidad\ActivoFijo;

use App\Entity\Contabilidad\ActivoFijo\ActivoFijoCuentas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivoFijoCuentasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_activo')
            ->add('id_cuenta_activo')
            ->add('id_subcuenta_activo')
            ->add('id_centro_costo_activo')
            ->add('id_area_responsabilidad_activo')
            ->add('id_cuenta_depreciacion')
            ->add('id_subcuenta_depreciacion')
            ->add('id_cuenta_gasto')
            ->add('id_subcuenta_gasto')
            ->add('id_centro_costo_gasto')
            ->add('id_elemento_gasto_gasto')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ActivoFijoCuentas::class,
        ]);
    }
}
