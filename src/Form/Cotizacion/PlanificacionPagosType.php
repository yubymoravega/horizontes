<?php

namespace App\Form\Cotizacion;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanificacionPagosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha_maxima_pago', DateType::class,array(
                'input'=>'datetime',
                'widget'=>'single_text',
                'placeholder'=>'Fecha',
                'label'=>'Fecha Máxima de Pago'
            ))
            ->add('plazos', ChoiceType::class, [
                'choices' => [
                    'Diario' => 1,
                    'Semanal' => 2,
                    'Quincenal' => 3,
                    'Mensual' => 4
                ],
                'label' => 'Plazos de Pago',
            ])
            ->add('calcular', ButtonType::class)
            ->add('imprimir', ButtonType::class)
            ->add('id_cotizacion', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}