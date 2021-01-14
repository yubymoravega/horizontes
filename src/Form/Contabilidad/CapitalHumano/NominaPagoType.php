<?php

namespace App\Form\Contabilidad\CapitalHumano;

use App\Entity\Contabilidad\CapitalHumano\NominaPago;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NominaPagoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comision')
            ->add('vacaciones')
            ->add('horas_extra')
            ->add('otros')
            ->add('total_ingresos')
            ->add('ingresos_cotizables_tss')
            ->add('isr')
            ->add('ars')
            ->add('afp')
            ->add('cooperativa')
            ->add('plan_medico_complementario')
            ->add('restaurant')
            ->add('total_deducido')
            ->add('sueldo_neto_pagar')
            ->add('afp_empleador')
            ->add('sfs_empleador')
            ->add('srl_empleador')
            ->add('infotep_empleador')
            ->add('mes')
            ->add('anno')
            ->add('fecha')
//            ->add('elaborada')
//            ->add('aprobada')
//            ->add('id_empleado')
//            ->add('id_usuario_aprueba')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NominaPago::class,
        ]);
    }
}
