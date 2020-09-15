<?php

namespace App\Form\Contabilidad\Inventario;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ValeSalidaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mercancia', MercanciaType::class, [
                'mapped' => false,
                'auto_initialize' => true
            ])
            ->add('documento', DocumentoType::class, [
                'mapped' => false,
                'auto_initialize' => true
            ])
            ->add('fecha_solicitud', DateType::class, array(
                'input' => 'datetime',
                'attr' => ['class' => 'w-100'],
                'widget' => 'single_text',
                'placeholder' => 'Fecha'
            ))
            ->add('nro_solicitud', TextType::class, array(
                'attr' => ['class' => 'w-100'],
                'label'=> 'Nro. solicitud'
            ))
            ->add('nro_cuenta_deudora', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Cuenta deudora',
                'choice_label' => 'nro_cuenta_deudora',
            ))
            ->add('nro_subcuenta_deudora', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Subcuenta dedeudora',
                'choice_label' => 'nro_subcuenta_deudora',
            ))
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
        ;
    }

}
