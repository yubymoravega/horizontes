<?php

namespace App\Form\Contabilidad\Config;

use App\Entity\Contabilidad\Config\GrupoActivos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GrupoActivosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('porciento_deprecia_anno')
            ->add('descripcion')
            ->add('activo')
            ->add('id_cuenta')
            ->add('id_subcuenta')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GrupoActivos::class,
        ]);
    }
}
