<?php

namespace App\Form\Contabilidad\Config;

use App\Entity\Contabilidad\Config\CentroCosto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CentroCostoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('codigo')
            ->add('activo')
            ->add('id_cuenta')
            ->add('id_subcuenta')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CentroCosto::class,
        ]);
    }
}
