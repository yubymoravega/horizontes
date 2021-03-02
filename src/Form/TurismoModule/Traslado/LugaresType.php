<?php

namespace App\Form\TurismoModule\Traslado;

use App\Entity\TurismoModule\Traslado\Lugares;
use App\Entity\TurismoModule\Traslado\Zona;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LugaresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class,[
                'required' => true,
                'attr' => ['class' => 'w-100'],
                'label' => 'Nombre',
            ])
            ->add('habilitado',CheckboxType::class,[
                'required' => true,
                'attr' => ['class' => 'w-100'],
                'label' => 'Habilitado',
            ])
            ->add('zona',EntityType::class,[
                'class' => Zona::class,
                'required' => true,
                'attr' => ['class' => 'w-100'],
                'choice_label' => 'nombre',
                'label' => 'Zona',
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
            'data_class' => Lugares::class,
        ]);
    }
}
