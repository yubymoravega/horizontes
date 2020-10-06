<?php

namespace App\Form\Contabilidad\Venta;

use App\Entity\Contabilidad\Venta\ObligacionCobro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObligacionCobroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_cliente')
            ->add('tipo_cliente')
            ->add('fecha_factura')
            ->add('importe_factura')
            ->add('cuenta_obligacion')
            ->add('subcuenta_obligacion')
            ->add('resto_pagar')
            ->add('liquidada')
            ->add('activo')
            ->add('id_factura')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ObligacionCobro::class,
        ]);
    }
}
