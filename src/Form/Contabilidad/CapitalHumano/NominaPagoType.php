<?php

namespace App\Form\Contabilidad\CapitalHumano;

use App\Entity\Contabilidad\CapitalHumano\NominaPago;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NominaPagoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comision',TextType::class, array(
                'label'=>'Comisión',
            ))
            ->add('vacaciones',TextType::class, array(
                'label'=>'Vacaciones',
            ))
            ->add('horas_extra',TextType::class, array(
                'label'=>'Horas extra',
            ))
            ->add('otros',TextType::class, array(
                'label'=>'Otros',
            ))
            ->add('total_ingresos',TextType::class, array(
                'label'=>'Total Ingresos',
            ))
            ->add('ingresos_cotizables_tss',TextType::class, array(
                'label'=>'Ingresos cotizables a TSS',
            ))
            ->add('isr',TextType::class, array(
                'label'=>'I/S/R',
            ))
            ->add('ars',TextType::class, array(
                'label'=>'ARS (3.04%)',
            ))
            ->add('afp',TextType::class, array(
                'label'=>'AFP (2.87%)',
            ))
            ->add('cooperativa',TextType::class, array(
                'label'=>'Cooperativa',
            ))
            ->add('plan_medico_complementario',TextType::class, array(
                'label'=>'Plan Médico Complementario',
            ))
            ->add('restaurant',TextType::class, array(
                'label'=>'Restaurant',
            ))
            ->add('total_deducido',TextType::class, array(
                'label'=>'Total Deducido',
            ))
            ->add('sueldo_neto_pagar',TextType::class, array(
                'label'=>'Sueldo Neto a Pagar',
            ))
            ->add('afp_empleador',TextType::class, array(
                'label'=>'AFP (7.10%)',
            ))
            ->add('sfs_empleador',TextType::class, array(
                'label'=>'SFS (7.09%)',
            ))
            ->add('srl_empleador',TextType::class, array(
                'label'=>'SRL (1.1%)',
            ))
            ->add('infotep_empleador',TextType::class, array(
                'label'=>'Infotep (1%)',
            ))
            ->add('impuesto_sobre_renta', ImpuestoSobreRentaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
//            'data_class' => NominaPago::class,
        ]);
    }
}
