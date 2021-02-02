<?php

namespace App\Form\TurismoModule\Utils;

use App\Entity\TurismoModule\Utils\CreditosPrecioVenta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CreditosPrecioVentaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identificador_servicio',TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Servicio',
            ])
            ->add('credito',TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Credito',
            ])
            ->add('importe',TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Importe',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreditosPrecioVenta::class,
        ]);
    }
}
