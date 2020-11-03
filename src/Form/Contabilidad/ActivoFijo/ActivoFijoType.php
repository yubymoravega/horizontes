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
            ->add('nro_consecutivo')
            ->add('fecha_alta')
            ->add('nro_documento_baja')
            ->add('fecha_baja')
            ->add('descripcion')
            ->add('valor_inicial')
            ->add('depreciacion_acumulada')
            ->add('valor_real')
            ->add('annos_vida_util')
            ->add('pais')
            ->add('modelo')
            ->add('tipo')
            ->add('marca')
            ->add('nro_motor')
            ->add('nro_serie')
            ->add('nro_chapa')
            ->add('nro_chasis')
            ->add('combustible')
            ->add('activo')
            ->add('id_tipo_movimiento')
            ->add('id_tipo_movimiento_baja')
            ->add('id_area_responsabilidad')
            ->add('id_grupo_activo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ActivoFijo::class,
        ]);
    }
}
