<?php

namespace App\Form\TurismoModule\Solicitud;

use App\Entity\TurismoModule\Solicitud\SolTour;
use App\Entity\TurismoModule\Tour\Tour;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SolTourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cant_adulto', NumberType::class,[
                'required' => true,
                'attr' => ['class' => 'w-10'],
                'label' => 'Cantidad de Adultos',
            ])
            ->add('cant_nino', NumberType::class,[
                'required' => true,
                'attr' => ['class' => 'w-10'],
                'label' => 'Cantidad de Niños',
            ])
            ->add('fecha_salida',DateTimeType::class,[
                'required' => true,
                'attr' => ['class' => 'w-10'],
                'label' => 'Fecha de Salida',
            ])
            ->add('comentario',TextareaType::class,[
                'required' => false,
                'attr' => ['class' => 'w-10','rows'=>'3'],
                'label' => 'Comentario',
            ])
            ->add('tour',EntityType::class,[
                'class' => Tour::class,
                'attr' => ['class' => 'w-100'],
                'choice_label' => 'nombre',
                'label' => 'Nombre del Tour',
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
        $resolver->setDefaults([
            'data_class' => SolTour::class,
        ]);
    }
}
