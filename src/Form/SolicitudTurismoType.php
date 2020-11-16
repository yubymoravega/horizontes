<?php

namespace App\Form;

use App\Entity\SolicitudTurismo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SolicitudTurismoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vueloCantidadAdultos',  null, ['required'=> false])
            ->add('vueloCantidadNinos'  ,  null, ['required'=> false])
            ->add('vueloOrigen',  null, ['required'=> false])
            ->add('VueloDestino',  null, ['required'=> false])
            ->add('vueloIda' ,TextType::class,  ['required'=> false])
            ->add('vueloVuelta' ,TextType::class,  ['required'=> false])
            ->add('vueloComentario' ,TextareaType::class,   ['required'=> false])
            ->add('hotelDestino',  null, ['required'=> false])
            ->add('hotelNombre',  null, ['required'=> false])
            ->add('hotelCategoria',  null, ['required'=> false])
            ->add('hotelPlan',  null, ['required'=> false])
            ->add('hotelDesde', TextType::class,  ['required'=> false])
            ->add('hotelHasta', TextType::class, ['required'=> false])
            ->add('hotelComentario' ,TextareaType::class, ['required'=> false])
            ->add('tranferLlegada' ,TextType::class , ['required'=> false])
            ->add('tramferSalida',TextType::class ,  ['required'=> false])
            ->add('tramferLugar',  null, ['required'=> false])
            ->add('tramferDestino',  null, ['required'=> false])
            ->add('tramferVehiculo',  null, ['required'=> false])
            ->add('tramferComentario' ,TextareaType::class, ['required'=> false])
            ->add('tourNombre',   null, ['required'=> false])
            ->add('tourFecha', TextType::class,   ['required'=> false])
            ->add('tourComentario' ,TextareaType::class,  ['required'=> false])
            ->add('tourCantidadAdultos',  null, ['required'=> false])
            ->add('tourCantidadNinos',  null, ['required'=> false])
            ->add('RentTipoVehiculo',  null, ['required'=> false])
            ->add('rentLugarRecogida',  null, ['required'=> false])
            ->add('rentLugarEntrega',  null, ['required'=> false])
            ->add('rentFechaDesde', TextType::class,  ['required'=> false])
            ->add('rentFechaHasta', TextType::class,  ['required'=> false])
            ->add('rentComentario' ,TextareaType::class , ['required'=> false])
            //->add('empleado')
           // ->add('idCliente')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SolicitudTurismo::class,
        ]);
    }
}
