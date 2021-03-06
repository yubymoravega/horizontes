<?php

namespace App\Form\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Almacen;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrudAddDescripcionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion', TextType::class)
            ->add('adicionar', SubmitType::class)
        ;
    }
}
