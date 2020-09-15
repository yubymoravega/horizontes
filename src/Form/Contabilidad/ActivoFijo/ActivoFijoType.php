<?php

namespace App\Form\Contabilidad\ActivoFijo;

use App\Entity\Contabilidad\ActivoFijo\ActivoFijo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivoFijoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nro_inventario')
            ->add('importe')
            ->add('descripcion')
            ->add('fecha')
            ->add('activo')
            ->add('nro_cuenta_deprecia')
            ->add('baja')
            ->add('fecha_baja')
            ->add('motivo_baja')
            ->add('id_unidad')
            ->add('id_grupo_activo')
            ->add('id_proveedor')
            ->add('id_tipo_documento_activo')
            ->add('id_cuenta_deprecia')
            ->add('id_elemento_gasto')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ActivoFijo::class,
        ]);
    }
}
