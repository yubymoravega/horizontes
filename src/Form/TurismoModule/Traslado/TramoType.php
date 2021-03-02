<?php

namespace App\Form\TurismoModule\Traslado;

use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\TurismoModule\Traslado\Lugares;
use App\Entity\TurismoModule\Traslado\TipoTraslado;
use App\Entity\TurismoModule\Traslado\TipoVehiculo;
use App\Entity\TurismoModule\Traslado\Tramo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TramoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('proveedor',EntityType::class,[
                'class' => Proveedor::class,
                'attr' => ['class' => 'w-100'],
                'choice_label' => 'nombre',
                'label' => 'Proveedor',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
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
            ->add('ida_vuelta', ChoiceType::class, [
                'choices' => ['Ida-Retorno' => 1, 'Ida' => 0],
                'label' => 'Vuelta',
                'required' => true,
                'attr' => ['class' => 'w-100'],
            ])
            ->add('vehiculo',EntityType::class,[
                'class' => TipoVehiculo::class,
                'attr' => ['class' => 'w-100'],
                'choice_label' => 'nombre',
                'label' => 'Vehículo',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('traslado',EntityType::class,[
                'class' => TipoTraslado::class,
                'attr' => ['class' => 'w-100'],
                'choice_label' => 'nombre',
                'label' => 'Tipo Traslado',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('precio',TextType::class,[
                'required' => true,
                'attr' => ['class' => 'w-100'],
                'label' => 'Precio',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tramo::class,
        ]);
    }
}
