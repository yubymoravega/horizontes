<?php

namespace App\Form\TurismoModule\hotel;

use App\Entity\TurismoModule\hotel\Hotel;
use App\Entity\TurismoModule\hotel\PlanHotel;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class,[
                'required' => true,
                'attr' => ['class' => 'w-10'],
                'label' => 'Nombre del Hotel',
            ])
            ->add('categoria',ChoiceType::class,[
                'choices'  => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
                'required' => true,
                'attr' => ['class' => 'w-10'],
                'label' => 'Categoria del Hotel',
            ])
            ->add('planHotel',EntityType::class,[
                'required' => true,
                'choice_label' => 'nombre',
                'attr' => ['class' => 'w-100'],
                'label' => 'Plan',
                'class'=>PlanHotel::class,
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
            'data_class' => Hotel::class,
        ]);
    }
}
