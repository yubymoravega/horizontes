<?php

namespace App\Form\Contabilidad\Config;

use App\Entity\Contabilidad\Config\CuentaCriterioAnalisis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CuentaCriterioAnalisisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_cuenta')
            ->add('id_criterio_analisis')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CuentaCriterioAnalisis::class,
        ]);
    }
}
