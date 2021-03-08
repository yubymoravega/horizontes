<?php

namespace App\Form\Contabilidad\CapitalHumano;

use App\Entity\Contabilidad\CapitalHumano\RangoEscalaDGII;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RangoEscalaDGIIType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anno',TextType::class, array(
                'label'=>'Año'
            ))
            ->add('escala',TextType::class, array(
                'label'=>'Escala Anual'
            ))
            ->add('por_ciento',TextType::class, array(
                'label'=>'%'
            ))
            ->add('minimo',TextType::class, array(
                'label'=>'Mínimo'
            ))
            ->add('maximo',TextType::class, array(
                'label'=>'Máximo'
            ))
            ->add('valor_fijo',TextType::class, array(
                'label'=>'Valor Fijo'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RangoEscalaDGII::class,
        ]);
    }
}
