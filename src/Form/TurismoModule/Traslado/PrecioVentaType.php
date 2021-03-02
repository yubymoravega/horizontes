<?php

namespace App\Form\TurismoModule\Traslado;

use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\TurismoModule\Traslado\PrecioVenta;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrecioVentaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tramo', ChoiceType::class, [
                'label' => 'Tramo',
                'required' => true,
                'attr' => ['class' => 'w-100'],
            ])
            //->add('tramo')
            ->add('poerciento',NumberType::class,[
                'required' => true,
                'attr' => ['class' => 'w-100'],
                'label' => 'Porciento',
            ])
            ->add('fijo',NumberType::class,[
                'required' => true,
                'attr' => ['class' => 'w-100'],
                'label' => 'Fijo',
            ])
            ->add('precio_venta',NumberType::class,[
                'required' => true,
                'mapped'=> false,
                'attr' => ['class' => 'w-10'],
                'label' => 'Precio de Venta',
            ])
            ->add('precio_costo',NumberType::class,[
                'required' => true,
                'mapped'=> false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Precio de Costo',
            ])
            /*->add('proveedor',EntityType::class,[
                'required' => true,
                'choice_label' => 'nombre',
                'attr' => ['class' => 'w-100'],
                'label' => 'Proveedor',
                'mapped'=> false,
                'class'=>Proveedor::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true');
                }
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PrecioVenta::class,
        ]);
    }
}
