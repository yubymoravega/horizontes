<?php

namespace App\Form\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Servicios;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiciosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minimo_pagar_valor_fjo',TextType::class,array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Valor Fijo',
            ))
            ->add('minimo_pagar_porciento',TextType::class,array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Porciento (%)',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Servicios::class,
        ]);
    }
}
