<?php

namespace App\Form\RemesasModule\Configuracion;

use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Inventario\Proveedor;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CostoVentaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_moneda', EntityType::class, [
                'class' => Moneda::class,
                'choice_label' => 'nombre',
                'attr' => ['class' => 'w-100'],
                'label' => 'Moneda',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('id_proveedor', EntityType::class, [
                'class' => Proveedor::class,
                'choice_label' => 'nombre',
                'attr' => ['class' => 'w-100'],
                'label' => 'Proveedor',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('minimo', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Mínimo',
            ])
            ->add('maximo', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Máximo',
            ])
            ->add('costo_fijo', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Valor Fijo',
            ])
            ->add('costo_porciento', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Porciento(%)',
            ])
            ->add('venta_fijo', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Valor Fijo',
            ])
            ->add('venta_porciento', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Porciento(%)',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
