<?php

namespace App\Form\Contabilidad\Venta;

use App\Entity\Contabilidad\Venta\ContratosCliente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratosClienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nro_contrato')
            ->add('anno')
            ->add('fecha_aprobado')
            ->add('fecha_vencimiento')
            ->add('activo')
            ->add('importe')
            ->add('id_cliente')
            ->add('id_moneda')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContratosCliente::class,
        ]);
    }
}
