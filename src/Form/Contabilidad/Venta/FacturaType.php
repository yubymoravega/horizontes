<?php

namespace App\Form\Contabilidad\Venta;

use App\Entity\Contabilidad\Venta\Factura;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FacturaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha_factura')
            ->add('tipo_cliente')
            ->add('id_cliente')
            ->add('nro_factura')
            ->add('id_contrato')
            ->add('cuenta_obligacion')
            ->add('subcuenta_obligacion')
            ->add('movimiento_venta', MovimientoVentaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Factura::class,
        ]);
    }
}
