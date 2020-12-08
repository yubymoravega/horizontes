<?php

namespace App\Form\Contabilidad\General;

use App\Entity\Contabilidad\Config\TipoComprobante;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComprobanteOperacionesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo_comprobante', EntityType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Tipo de comprobante',
                'class' => TipoComprobante::class,
                'choice_value' => 'id',
                'choice_label' => function (TipoComprobante $eg) {
                    return $eg->getAbreviatura() . ' - ' . $eg->getDescripcion();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true');
                }
            ])
//            ->add('nro_comprobante', NumberType::class, [
//                'attr' => ['class' => 'w-100'],
//            ])
            ->add('documento', TextType::class,[
                'attr' => ['class' => 'w-100'],
                'label' => 'Documento',
            ])
            ->add('explicacion', TextareaType::class,[
                'attr' => ['class' => 'w-100'],
                'label' => 'Explicación',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
