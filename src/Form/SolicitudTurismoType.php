<?php

namespace App\Form;

use App\Entity\SolicitudTurismo;
use App\Entity\VueloOrigen;
use App\Entity\VueloDestino; 
use App\Entity\HotelDestino; 
use App\Entity\HotelOrigen; 
use App\Entity\TransferDestino;
use App\Entity\TransferOrigen;
use App\Entity\TourNombre; 
use App\Entity\RentRecogida;
use App\Entity\RentEntrega;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;


class SolicitudTurismoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vueloCantidadAdultos', ChoiceType::class, [
                'choices'  => [
                    '-' => null,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                ]], ['required'=> false])
            ->add('vueloCantidadNinos'  ,  ChoiceType::class, [
                'choices'  => [
                    '-' => null,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                ]], ['required'=> false])
            ->add('vueloOrigen', EntityType::class, [
                'mapped' => false,
                'class' => VueloOrigen::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.nombre', 'ASC');
                },
                'choice_label' => "nombre",
                'choice_value' => "nombre",
            ])
            ->add('VueloDestino', EntityType::class, [
                'mapped' => false,
                'class' => VueloDestino::class,
                'choice_label' => "nombre",
                'choice_value' => "nombre",
                
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('vueloIda' ,TextType::class,  ['required'=> false])
            ->add('vueloVuelta' ,TextType::class,  ['required'=> false])
            ->add('vueloComentario' ,TextareaType::class,   ['required'=> false])
            ->add('hotelDestino' , EntityType::class, [
                'mapped' => false,
                'class' => HotelDestino::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.nombre', 'ASC');
                },
                'choice_label' => "nombre",
                'choice_value' => "nombre",
            ])
            ->add('hotelNombre', EntityType::class, [
                'mapped' => false,
                'class' => HotelOrigen::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.nombre', 'ASC');
                },
                'choice_label' => "nombre",
                'choice_value' => "nombre",
            ])
            ->add('hotelCategoria',  ChoiceType::class, [
                'choices'  => [
                    '-' => null,
                    '1' => "1 Estrella",
                    '2' => "2 Estrellas",
                    '3' => "3 Estrellas",
                    '4' => "4 Estrellas",
                    '5' => "5 Estrellas",
                    
                ]], ['required'=> false])
            ->add('hotelPlan', ChoiceType::class, [
                'choices'  => [
                    '-' => null,
                    'all inclusive' => "all inclusive",
                    'desayuno incluido' => "desayuno incluido",
                    'desayuno y almuerzo incluido' => "desayuno y almuerzo incluido",
                    'solo alojamiento' => "solo alojamiento",  
                ]], ['required'=> false])
            ->add('hotelDesde', TextType::class,  ['required'=> false])
            ->add('hotelHasta', TextType::class, ['required'=> false])
            ->add('hotelComentario' ,TextareaType::class, ['required'=> false])
            ->add('tranferLlegada' ,TextType::class , ['required'=> false])
            ->add('tramferSalida',TextType::class ,  ['required'=> false])
            ->add('tramferLugar' ,EntityType::class, [
                'mapped' => false,
                'class' => TransferOrigen::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.nombre', 'ASC');
                },
                'choice_label' => "nombre",
                'choice_value' => "nombre",
            ])
            ->add('tramferDestino',  EntityType::class, [
                'mapped' => false,
                'class' => TransferDestino::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.nombre', 'ASC');
                },
                'choice_label' => "nombre",
                'choice_value' => "nombre",
            ])
            ->add('tramferVehiculo',  null, ['required'=> false])
            ->add('tramferComentario' ,TextareaType::class, ['required'=> false])
            ->add('tourNombre', EntityType::class, [
                'mapped' => false,
                'class' => TourNombre::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.nombre', 'ASC');
                },
                'choice_label' => "nombre",
                'choice_value' => "nombre",
            ])
            ->add('tourFecha', TextType::class,   ['required'=> false])
            ->add('tourComentario' ,TextareaType::class,  ['required'=> false])
           // ->add('tourCantidadAdultos',  null, ['required'=> false])
            //->add('tourCantidadNinos',  null, ['required'=> false])
            ->add('RentTipoVehiculo' , ChoiceType::class, [
                'choices'  => [
                    '-' => null,
                    'Económico/Intermedio' => "Económico/Intermedio",
                    'Estándar/Full-size' => "Estándar/Full-size",
                    'Premium' => "Premium",
                    'Minivan/Van' => "Minivan/Van",
                    'Camioneta' => "Camioneta",
                    'Vehículos de Lujo' => "Vehículos de Lujo",
                ]], ['required'=> false])
            ->add('rentLugarRecogida',  EntityType::class, [
                'mapped' => false,
                'class' => RentRecogida::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.nombre', 'ASC');
                },
                'choice_label' => "nombre",
                'choice_value' => "nombre",
            ])
            ->add('rentLugarEntrega',  EntityType::class, [
                'mapped' => false,
                'class' => RentEntrega::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.nombre', 'ASC');
                },
                'choice_label' => "nombre",
                'choice_value' => "nombre",
            ])
            ->add('rentFechaDesde', TextType::class,  ['required'=> false])
            ->add('rentFechaHasta', TextType::class,  ['required'=> false])
            ->add('rentComentario' ,TextareaType::class , ['required'=> false])
            ->add('hotelAdultos',   ChoiceType::class, [
                'choices'  => [
                    '-' => null,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                ]], ['required'=> false])
            ->add('hotelNinos',   ChoiceType::class, [
                'choices'  => [
                    '-' => null,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                ]], ['required'=> false])
            ->add('tramferAdultos',   ChoiceType::class, [
                'choices'  => [
                    '-' => null,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                ]], ['required'=> false])
            ->add('tramferNinos',   ChoiceType::class, [
                'choices'  => [
                    '-' => null,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                ]], ['required'=> false])
            ->add('tourNinos',   ChoiceType::class, [
                'choices'  => [
                    '-' => null,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                ]], ['required'=> false])
            ->add('tourAdultos',    ChoiceType::class, [
                'choices'  => [
                    '-' => null,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                ]], ['required'=> false])
            ->add('rentCantidadPersonas',  null, ['required'=> false])
            ->add('tramferIdaVuelta'  ,  ChoiceType::class, [
                'choices'  => [
                    '-' => null,
                    '-' => "-",
                    'Solo Ida' => "Solo Ida",
                    'Ida & Vuelta' => "Ida & Vuelta",
                ]], ['required'=> false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SolicitudTurismo::class,
        ]);
    }
}
