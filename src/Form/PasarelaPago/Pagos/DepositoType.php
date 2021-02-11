<?php

namespace App\Form\PasarelaPago\Pagos;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepositoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('transaccion', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Transzacción',
                'choices' => ['Depósito' => 0, 'zeller' => 1, 'Transferencia' => 2],
            ])
            ->add('monto', TextType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Monto',
            ])
            ->add('banco', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Banco',
            ])
            ->add('cuenta', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Cuenta',
            ])
            ->add('nro_transaccion', TextType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'No. Transacción',
            ])
            ->add('nota', TextType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Nota',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
