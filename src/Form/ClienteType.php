<?php

namespace App\Form;

use App\Entity\Cliente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class ClienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellidos')
            ->add('correo ',null, ['required'=> false])
            ->add('direccion')
           // ->add('token')
            //->add('fecha')
            //->add('usuario')
            ->add('comentario')
            ->add('telefono')
            ->add('continuar', SubmitType::class, [
                'attr' => ['class' => 'btn btn-sm btn-default btn-icon btn-icon-right btn-nuka-effect']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cliente::class,
        ]);
    }
}
