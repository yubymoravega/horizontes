<?php

namespace App\Form\Contabilidad\Config;

use App\Entity\Contabilidad\Config\ElementoGasto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElementoGastoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo')
            ->add('descripcion')
            ->add('activo')
            ->add('id_cuenta')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ElementoGasto::class,
        ]);
    }
}
