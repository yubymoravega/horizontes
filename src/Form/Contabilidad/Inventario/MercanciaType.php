<?php

namespace App\Form\Contabilidad\Inventario;

use App\Entity\Contabilidad\Inventario\Mercancia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MercanciaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo')
            ->add('descripcion')
            ->add('precio_compra')
            ->add('materiales_auxiliares')
            ->add('activo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mercancia::class,
        ]);
    }
}
