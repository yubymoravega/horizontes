<?php

namespace App\Form\Contabilidad\CapitalHumano;

use App\Entity\Contabilidad\CapitalHumano\ImpuestoSobreRenta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImpuestoSobreRentaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('seguridad_social_mensual')
            ->add('salario_bruto_anual')
            ->add('seguridad_social_anual')
            ->add('salario_despues_seguridad_social')
            ->add('monto_segun_rango')
            ->add('monto_segun_rango_escala')
            ->add('excedente_segun_rango_escala')
            ->add('por_ciento_impuesto_excedente')
            ->add('monto_adicional_rango_escala')
            ->add('impuesto_renta_pagar_anual')
            ->add('impuesto_renta_pagar_mensual')
            ->add('fecha')
            ->add('id_empleado')
            ->add('id_nomina_pago')
            ->add('id_rango_escala')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImpuestoSobreRenta::class,
        ]);
    }
}
