<?php

namespace App\Form\Contabilidad\Venta;

use App\Entity\Contabilidad\Venta\MovimientoVenta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovimientoVentaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mercancia')
            ->add('codigo')
            ->add('cantidad')
            ->add('precio')
            ->add('descuento_recarga')
            ->add('existencia')
            ->add('cuenta_deudora')
            ->add('subcuenta_deudora')
            ->add('cuenta_acreedora')
            ->add('subcuenta_acreedora')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MovimientoVenta::class,
        ]);
    }
}
