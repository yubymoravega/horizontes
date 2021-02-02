<?php

namespace App\Form\TurismoModule\Utils;

use App\Entity\TurismoModule\Utils\ConfigPrecioVentaServicio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ConfigPrecioVentaServicioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identificador_servicio',TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Servicio',
            ])
            ->add('prociento',TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Porciento',
            ])
            ->add('valor_fijo',TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Valor Fijo',
            ])
            ->add('credito', CreditosPrecioVentaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ConfigPrecioVentaServicio::class,
        ]);
    }
}
