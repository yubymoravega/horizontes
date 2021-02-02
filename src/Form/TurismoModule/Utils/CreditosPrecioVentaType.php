<?php

namespace App\Form\TurismoModule\Utils;

use App\Entity\Contabilidad\Config\Servicios;
use App\Entity\TurismoModule\Utils\CreditosPrecioVenta;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CreditosPrecioVentaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identificador_servicio',EntityType::class, [
                'class' => Servicios::class,
                'choice_label' => 'nombre',
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Servicio',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.id != 11')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('importe',TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Importe',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreditosPrecioVenta::class,
        ]);
    }
}
