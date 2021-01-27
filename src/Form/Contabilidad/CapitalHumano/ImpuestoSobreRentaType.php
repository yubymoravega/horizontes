<?php

namespace App\Form\Contabilidad\CapitalHumano;

use App\Entity\Contabilidad\CapitalHumano\ImpuestoSobreRenta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ImpuestoSobreRentaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('seguridad_social_mensual',TextType::class, array(
                'label'=>'Seguridad Social Mensual',
            ))
            ->add('salario_bruto_anual',TextType::class, array(
                'label'=>'Salario Bruto Anual',
            ))
            ->add('seguridad_social_anual',TextType::class, array(
                'label'=>'Seguridad Social Anual',
            ))
            ->add('salario_despues_seguridad_social',TextType::class, array(
                'label'=>'Salario Despúes de Seguridad Social',
            ))
//            ->add('monto_segun_rango')
            ->add('monto_segun_rango_escala',TextType::class, array(
                'label'=>'Monto Según Rango de Escala DGII',
            ))
            ->add('excedente_segun_rango_escala',TextType::class, array(
                'label'=>'Excedente Según Rango de Escala DGII',
            ))
            ->add('por_ciento_impuesto_excedente',TextType::class, array(
                'label'=>'% de Impuesto del Excedente',
            ))
            ->add('monto_adicional_rango_escala',TextType::class, array(
                'label'=>'Monto Adicional Según Rango de Escala DGII',
            ))
            ->add('impuesto_renta_pagar_anual',TextType::class, array(
                'label'=>'Impuesto sobre la Renta a Pagar Anual',
            ))
            ->add('impuesto_renta_pagar_mensual',TextType::class, array(
                'label'=>'Impuesto sobre la Renta a Pagar Mensual',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImpuestoSobreRenta::class,
        ]);
    }
}
