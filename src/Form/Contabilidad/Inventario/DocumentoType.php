<?php

namespace App\Form\Contabilidad\Inventario;

use App\Entity\Contabilidad\Inventario\Documento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo')
            ->add('descripcion')
            ->add('cantidad')
            ->add('importe')
            ->add('precio')
            ->add('existencia')
            ->add('is_producto')
            ->add('nro_tipo_anno')
            ->add('fecha')
            ->add('activo')
            ->add('id_unidad_medida')
            ->add('id_tipo_documento')
            ->add('id_configuracion_inicial')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Documento::class,
        ]);
    }
}
