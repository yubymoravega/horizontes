<?php

namespace App\Form\TurismoModule\Traslado;

use App\Entity\TurismoModule\Traslado\TipoVehiculo;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TipoVehiculoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class,[
                'required' => true,
                'attr' => ['class' => 'w-100'],
                'label' => 'Marca',
            ])
            ->add('cantidad_ini_persona',TextType::class,[
                'required' => true,
                'attr' => ['class' => 'w-100'],
                'label' => 'Cantidad Inicial de Personas',
            ])
            ->add('cantidad_fin_persona',TextType::class,[
                'required' => true,
                'attr' => ['class' => 'w-100'],
                'label' => 'Cantidad final de Personas',
            ])
            /*->add('picture',FileType::class,[
                'required' => false,
                'attr' => ['class' => 'hidden w-100 form-control-file','placeholder'=>'Seleccione una imagen','accept'=>'.jpg,.png,.jpeg,.gif'],
                'label' => 'Seleccione una imagen',
            ])*/

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TipoVehiculo::class,
        ]);
    }
}
