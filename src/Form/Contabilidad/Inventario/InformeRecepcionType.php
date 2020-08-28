<?php

namespace App\Form\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\UnidadMedida;
use App\Entity\Contabilidad\Inventario\Proveedor;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformeRecepcionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo_mercancia', TextType::class, [
                'required' => true,
                'attr' => ['class' => 'w-100']
            ])
            ->add('descripcion_mercancia', TextType::class, [
                'attr' => ['class' => 'w-100']
            ])
            ->add('unidad_medida', EntityType::class, [
                'attr' => ['class' => 'w-100'],
                'class' => UnidadMedida::class,
                'choice_label' => 'nombre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('cantidad_mercancia', TextType::class, [
                'attr' => ['class' => 'w-100']
            ])
            ->add('importe_mercancia', TextType::class, [
                'attr' => ['class' => 'w-100']
            ])
            ->add('precio_mercancia', TextType::class, [
                'attr' => ['class' => 'w-100'],
                'disabled' => true
            ])
            ->add('fecha_mercancia', DateType::class, array(
                'input' => 'datetime',
                'attr' => ['class' => 'w-100'],
                'widget' => 'single_text',
                'placeholder' => 'Fecha'
            ))
            ->add('existencia_mercancia', TextType::class, [
                'required' => false,
                'disabled' => true,
                'attr' => ['class' => 'w-100']
            ])
            ->add('existencia_incremento_mercancia', TextType::class, [
                'attr' => ['class' => 'w-100']
            ])
            ->add('cuenta_inventario', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
//                'choice_label' => 'nro_cuenta',
            ))
            ->add('cuenta_acreedora', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
//                'choice_label' => 'nro_cuenta',
            ])
            ->add('subcuenta_inventario', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
//                'choice_label' => 'nro_subcuenta',
//                'choice_value'=>'nro_subcuenta',
            ])
            ->add('proveedor', EntityType::class, [
                'class' => Proveedor::class,
                'attr' => ['class' => 'w-100'],
                'choice_label' => 'nombre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ;
    }

//
//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults([
//            'data_class' => InformeRecepcion::class,
//        ]);
//    }
}
