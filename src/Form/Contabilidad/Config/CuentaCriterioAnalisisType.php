<?php

namespace App\Form\Contabilidad\Config;

use App\Entity\Contabilidad\Config\CriterioAnalisis;
use App\Entity\Contabilidad\Config\CuentaCriterioAnalisis;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CuentaCriterioAnalisisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_criterio_uno', EntityType::class, [
                'class' => CriterioAnalisis::class,
                'label' => 'Análisis 1',
                'choice_label' => function ($category) {
                    return $category->getAbreviatura().' - '.$category->getNombre();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('id_criterio_dos', EntityType::class, [
                'class' => CriterioAnalisis::class,
                'label' => 'Análisis 2',
                'choice_label' => function ($category) {
                    return $category->getAbreviatura().' - '.$category->getNombre();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('id_criterio_tres', EntityType::class, [
                'class' => CriterioAnalisis::class,
                'label' => 'Análisis 3',
                'choice_label' => function ($category) {
                    return $category->getAbreviatura().' - '.$category->getNombre();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('id_criterio_cuatro', EntityType::class, [
                'class' => CriterioAnalisis::class,
                'label' => 'Análisis 4',
                'choice_label' => function ($category) {
                    return $category->getAbreviatura().' - '.$category->getNombre();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
//        $resolver->setDefaults([
//            'data_class' => CuentaCriterioAnalisis::class,
//        ]);
    }
}
