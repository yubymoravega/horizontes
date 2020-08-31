<?php

namespace App\Form\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Subcuenta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubcuentaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nro_subcuenta')
            ->add('descripcion', TextareaType::class)
            ->add('deudora', ChoiceType::class, [
                'choices' => ['Deudora' => 1, 'Acreedora' => 0]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Subcuenta::class,
        ]);
    }
}
