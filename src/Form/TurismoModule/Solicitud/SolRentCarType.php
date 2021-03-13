<?php

namespace App\Form\TurismoModule\Solicitud;

use App\Entity\TurismoModule\Solicitud\SolRentCar;
use App\Entity\TurismoModule\Traslado\Lugares;
use App\Entity\TurismoModule\Traslado\TipoVehiculo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SolRentCarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cant_persona',NumberType::class,[
                'required' => true,
                'attr' => ['class' => 'w-10'],
                'label' => 'Cantidad de Personas',
            ])
            ->add('fecha_desde',DateTimeType::class,[
                'required' => true,
                'attr' => ['class' => 'w-10'],
                'label' => 'Fecha Desde',
            ])
            ->add('fecha_hasta',DateTimeType::class,[
                'required' => true,
                'attr' => ['class' => 'w-10'],
                'label' => 'Fecha Hasta',
            ])
            ->add('comentario',TextareaType::class,[
                'required' => false,
                'attr' => ['class' => 'w-10','rows'=>'3'],
                'label' => 'Comentario',
            ])
            ->add('entrega',EntityType::class,[
                'class' => Lugares::class,
                'attr' => ['class' => 'w-100'],
                'choice_label' => 'nombre',
                'label' => 'Entrega',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->andWhere('u.habilitado = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('recogida',EntityType::class,[
                'class' => Lugares::class,
                'attr' => ['class' => 'w-100'],
                'choice_label' => 'nombre',
                'label' => 'Recogida',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->andWhere('u.habilitado = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('tipoVehiculo',EntityType::class,[
                'required' => true,
                'choice_label' => 'nombre',
                'attr' => ['class' => 'w-100'],
                'label' => 'Tipo de Vehiculo',
                'class'=>TipoVehiculo::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SolRentCar::class,
        ]);
    }
}
