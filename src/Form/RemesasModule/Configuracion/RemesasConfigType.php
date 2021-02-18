<?php

namespace App\Form\RemesasModule\Configuracion;

use App\Entity\Pais;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemesasConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nuevo_pais', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Nombre del País',
            ])
            ->add('id_pais', EntityType::class, [
                'required' => false,
                'class' => Pais::class,
                'choice_label' => 'nombre',
                'attr' => ['class' => 'w-100'],
                'label' => 'País',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('costo_precio',CostoVentaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
