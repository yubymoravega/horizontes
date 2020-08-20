<?php

namespace App\Form\Contabilidad\CapitalHumano;

use App\Entity\Contabilidad\CapitalHumano\Cargo;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Unidad;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpleadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('correo',EmailType::class)
            ->add('salario_x_hora',MoneyType::class)
            ->add('fecha_alta', DateType::class, array(
                'input'=>'datetime',
                'widget'=>'single_text',
                'placeholder'=>'Fecha de alta'
            ))
            ->add('telefono')
            ->add('id_unidad', EntityType::class, [
                'mapped' => false,
                'class' => Unidad::class,
                'choice_label' => 'nombre',
                'label'=>'Unidad a la que pertenece',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('id_cargo', EntityType::class, [
                'mapped' => false,
                'class' => Cargo::class,
                'label'=>'Cargo en la Empresa',
                'choice_label' => 'nombre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('direccion_particular',TextareaType::class,array(
                'label'=>'Dirección particular',
            ))
            ->add('rol',ChoiceType::class,[
                'choices'=>[
                    'ROL_ADMIN'=>'ROL_ADMIN',
                    'ROL_EMPLEADO'=>'ROL_EMPLEADO',
                    'ROL_FACTURADOR'=>'ROL_FACTURADOR',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Empleado::class,
        ]);
    }
}
