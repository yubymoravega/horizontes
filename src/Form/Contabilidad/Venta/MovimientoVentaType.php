<?php

namespace App\Form\Contabilidad\Venta;

use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Venta\MovimientoVenta;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MovimientoVentaType extends AbstractType
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mercancia', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Tipo',
                'choices' => [
                    'Mercancía' => 1,
                    'Producto' => 2
                ]
            ])
            ->add('codigo')
            ->add('descripcion', TextType::class, [
                'attr' => ['class' => 'w-100', 'readonly' => true],
            ])
            ->add('um', TextType::class, [
                'attr' => ['class' => 'w-100', 'readonly' => true]
            ])
            ->add('cantidad', NumberType::class, [
                'attr' => ['class' => 'w-100']
            ])
            ->add('precio', NumberType::class, [
                'attr' => ['class' => 'w-100']
            ])
            ->add('descuento_recarga', NumberType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Descuento',
                'required'=>false
            ])
            ->add('existencia', NumberType::class, [
                'attr' => ['class' => 'w-100', 'readonly' => true]
            ])
        ;
    }

    /*public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MovimientoVenta::class,
        ]);
    }*/
}
