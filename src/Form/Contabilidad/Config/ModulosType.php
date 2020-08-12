<?php

namespace App\Form\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Modulo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModulosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('adicionar',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Modulo::class,
        ]);
    }
}
