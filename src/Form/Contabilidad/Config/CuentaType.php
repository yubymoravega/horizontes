<?php

namespace App\Form\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Cuenta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CuentaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nro_cuenta')
            ->add('descripcion', TextareaType::class)
            ->add('deudora', ChoiceType::class, [
                'choices' => ['Deudora' => 1, 'Acreedora' => 0]
            ])
            ->add('produccion', CheckboxType::class, [
                'label' => 'Producción',
                'required' => false
            ])
            ->add('patrimonio', CheckboxType::class, ['required' => false])
            ->add('elemento_gasto', CheckboxType::class, ['required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cuenta::class,
        ]);
    }
}
