<?php

namespace App\Form\Contabilidad\CapitalHumano;

use App\Controller\Contabilidad\CapitalHumano\EmpleadoController;
use App\Entity\Contabilidad\CapitalHumano\Cargo;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Unidad;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpleadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class)
            ->add('correo', EmailType::class)
            ->add('salario_x_hora')
            ->add('fecha_alta', DateType::class, array(
                'input' => 'datetime',
                'widget' => 'single_text',
                'placeholder' => 'Fecha de alta'
            ))
            ->add('telefono')
            ->add('id_unidad', EntityType::class, [
                'class' => Unidad::class,
                'choice_label' => 'nombre',
                'label' => 'Unidad a la que pertenece',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('id_cargo', EntityType::class, [
                'class' => Cargo::class,
                'label' => 'Cargo en la Empresa',
                'choice_label' => 'nombre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('direccion_particular', TextareaType::class, array(
                'label' => 'Dirección particular',
            ))
            ->add('rol', ChoiceType::class, [
                'label' => 'Rol que ejecuta',
                'choices' => EmpleadoController::getRoles()
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Empleado::class,
        ]);
    }
}
