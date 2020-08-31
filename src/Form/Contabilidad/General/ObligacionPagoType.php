<?php

namespace App\Form\Contabilidad\General;

use App\Entity\Contabilidad\General\ObligacionPago;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObligacionPagoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nro_cuenta')
            ->add('nro_subcuenta')
            ->add('valor_pagado')
            ->add('resto')
            ->add('liquidado')
            ->add('activo')
            ->add('id_proveedor')
            ->add('id_documento')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ObligacionPago::class,
        ]);
    }
}
