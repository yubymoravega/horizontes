<?php

namespace App\Form\TurismoModule\Solicitud;

use App\Entity\TurismoModule\Solicitud\SolTranfer;
use App\Entity\TurismoModule\Traslado\Lugares;
use App\Entity\TurismoModule\Traslado\TipoVehiculo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SolTranferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cant_adulto', NumberType::class,[
                'required' => true,
                'attr' => ['class' => 'w-10'],
                'label' => 'Cantidad de Adultos',
            ])
            ->add('cant_nino',NumberType::class,[
                'required' => true,
                'attr' => ['class' => 'w-10'],
                'label' => 'Cantidad de Niños',
            ])
            /*->add('fecha',DateTimeType::class,[
                'required' => true,
                'attr' => ['class' => 'w-10'],
                'label' => 'Fecha',
            ])
            ->add('fecha_salida',DateTimeType::class,[
                'required' => true,
                'attr' => ['class' => 'w-10'],
                'label' => 'Fecha de Salida',
            ])*/
            //->add('ida_retorno')
            ->add('comentario',TextareaType::class,[
                'required' => false,
                'attr' => ['class' => 'w-10','rows'=>'3'],
                'label' => 'Comentario',
            ])
            ->add('origen',EntityType::class,[
                'class' => Lugares::class,
                'attr' => ['class' => 'w-100'],
                'choice_label' => 'nombre',
                'label' => 'Origen',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->andWhere('u.habilitado = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('destino',EntityType::class,[
                'class' => Lugares::class,
                'attr' => ['class' => 'w-100'],
                'choice_label' => 'nombre',
                'label' => 'Destino',
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
            'data_class' => SolTranfer::class,
        ]);
    }
}
