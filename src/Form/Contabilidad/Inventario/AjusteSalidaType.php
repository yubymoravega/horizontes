<?php

namespace App\Form\Contabilidad\Inventario;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class AjusteSalidaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mercancia', MercanciaSalidaType::class, [
                'mapped' => false,
                'auto_initialize' => true
            ])
            ->add('documento', DocumentoType::class, [
                'mapped' => false,
                'auto_initialize' => true
            ])
            ->add('nro_cuenta_deudora', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Cuenta Deudora',
                'choice_label' => 'nro_cuenta',
            ))
            ->add('nro_subcuenta_deudora', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Subcuenta Deudora',
                'choice_label' => 'nro_subcuenta',
            ))
            ->add('observacion', TextareaType::class, [
                'label' => 'Observaciones',
                'mapped' => true,
                'attr' => ['class' => 'w-100']
            ])
            ->add('id_centro_costo', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Centro costo',
                'choice_label' => 'codigo',
            ))
            ->add('id_elemento_gasto', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Elemento de gasto',
                'choice_label' => 'codigo',
            ))
            ->add('list_mercancia', HiddenType::class);
    }
}
