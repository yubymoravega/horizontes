<?php

namespace App\Form\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Modulo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AjusteSalidaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mercancia', MercanciaSalidaType::class, [
                'mapped' => false,
                'auto_initialize' => true
            ])
            ->add('documento', DocumentoType::class, [
                'mapped' => false,
                'auto_initialize' => true
            ])
            ->add('nro_cuenta_deudora', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Cuenta Deudora',
                'choice_label' => 'nro_cuenta',
            ))
            ->add('nro_subcuenta_deudora', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Subcuenta Deudora',
                'choice_label' => 'nro_subcuenta',
            ))
            ->add('observacion', TextareaType::class, [
                'label' => 'Observaciones',
                'mapped' => true,
                'attr' => ['class' => 'w-100']
            ])
            ->add('id_centro_costo', EntityType::class, [
                'class' => CentroCosto::class,
                'choice_label' => 'nombre',
                'attr' => ['class' => 'w-100'],
                'label' => 'Centro costo',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('id_elemento_gasto', EntityType::class, [
                'class' => ElementoGasto::class,
                'choice_label' => 'descripcion',
                'attr' => ['class' => 'w-100'],
                'label' => 'Elemento de gasto',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.descripcion', 'ASC');
                }
            ])
            ->add('codigo_exp', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Código Expediente',
            ])
            ->add('descripcion_exp', TextType::class, [
                'attr' => ['class' => 'w-100', 'readonly' => true],
                'label' => 'Descripción Expediente',
                'required' => false,
            ])
            ->add('list_mercancia', HiddenType::class);
    }
}
