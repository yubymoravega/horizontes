<?php

namespace App\Form\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Impuesto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImpuestoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Nombre',
            ])
            ->add('valor', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Valor(%)',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Impuesto::class,
        ]);
    }
}
