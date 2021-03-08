<?php

namespace App\Form\TurismoModule\Visado;

use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\TurismoModule\Visado\ElementosVisa;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElementosVisaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo',TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Código',
            ])
            ->add('descripcion',TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Descripción',
            ])
            ->add('costo',TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Costo',
            ])
            ->add('id_proveedor', EntityType::class, [
                'class' => Proveedor::class,
                'choice_label' => 'nombre',
                'label' => 'Proveedor',
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
            'data_class' => ElementosVisa::class,
        ]);
    }
}
