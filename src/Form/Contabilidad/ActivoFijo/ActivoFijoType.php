<?php

namespace App\Form\Contabilidad\ActivoFijo;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivoFijoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nro_inventario', TextType::class,[
                'label'=>'Nro. Inventario',
                'disabled'=>true
            ])
            ->add('fecha_alta',DateType::class, array(
                'input'=>'datetime',
                'widget'=>'single_text',
                'placeholder'=>'Fecha',
                'label'=>'Fecha de Alta'
            ))
            ->add('fecha_ultima_depreciacion',DateType::class, array(
                'input'=>'datetime',
                'required'=>false,
                'widget'=>'single_text',
                'placeholder'=>'Fecha ultima depreciacion',
                'label'=>'Fecha Ultima Depreciación'
            ))
            ->add('descripcion', TextType::class,[
                'label'=>'Descripción'
            ])
            ->add('valor_inicial',TextType::class,[
                'label'=>'Valor Inicial'
            ])
            ->add('depreciacion_acumulada',TextType::class,[
                'label'=>'Depreciación Acumulada',
                'required'=>false
            ])
            ->add('valor_real',TextType::class,[
                'label'=>'Valor Real',
                'disabled'=>true
            ])
            ->add('annos_vida_util',TextType::class,[
                'label'=>'Años de Vida Util'
            ])
            ->add('pais', ChoiceType::class,[
                'label'=>'País'
            ])
            ->add('modelo',TextType::class,[
                'label'=>'Modelo'
            ])
            ->add('tipo',TextType::class,[
                'label'=>'Tipo de Activo Fijo'
            ])
            ->add('marca',TextType::class,[
                'label'=>'Marca'
            ])
            ->add('nro_motor',TextType::class,[
                'label'=>'Nro. Motor',
                'required'=>false
            ])
            ->add('nro_serie',TextType::class,[
                'label'=>'Nro. Serie',
                'required'=>false
            ])
            ->add('nro_chapa',TextType::class,[
                'label'=>'Nro. Chapa',
                'required'=>false
            ])
            ->add('nro_chasis',TextType::class,[
                'label'=>'Nro. Chasis',
                'required'=>false
            ])
            ->add('combustible',TextType::class,[
                'label'=>'Tipo de Combustible',
                'required'=>false
            ])
            ->add('id_grupo_activo', ChoiceType::class,[
                'label'=>'Grupo de Activo'
            ])
            ->add('activo_fijo_cuentas',ActivoFijoCuentasType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
//        $resolver->setDefaults([
//            'data_class' => ActivoFijo::class,
//        ]);
    }
}
