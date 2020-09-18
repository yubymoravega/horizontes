<?php

namespace App\Form\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Inventario\Documento;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cantidad_mercancia', TextType::class, [
                'required' => false,
                'label' => 'Cantidad',
                'attr' => ['class' => 'w-100']
            ])
            ->add('importe_mercancia', TextType::class, [
                'required' => false,
                'label' => 'Importe',
                'attr' => ['class' => 'w-100']
            ])
            ->add('id_moneda', EntityType::class, [
                'label' => 'Moneda',
                'class' => Moneda::class,
                'choice_label' => 'nombre',
                'attr' => ['class' => 'w-100'],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
//            ->add('importe_total', TextType::class, [
//                'required' => true,
////                'hidden' => true,
////                'disabled'=>true,
//                'label' => 'Importe Total',
//                'attr' => ['class' => 'w-100']
//            ])
//            ->add('nro_concecutivo',TextType::class, [
//                'required' => true,
//                'attr' => ['class' => 'w-100'],
//                'disabled' => true
//            ])
//            ->add('fecha', DateType::class, array(
//                'input' => 'datetime',
//                'attr' => ['class' => 'w-100'],
//                'widget' => 'single_text',
//                'placeholder' => 'Fecha'
//            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //  'data_class' => Documento::class,
        ]);
    }
}
