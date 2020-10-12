<?php

namespace App\Form\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\UnidadMedida;
use App\Entity\Contabilidad\Inventario\Mercancia;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MercanciaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Código',
            ])
            ->add('descripcion', TextType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Descripción',
                'required' => false,
            ])
            ->add('precio', TextType::class, [
                'attr' => ['class' => 'w-100'],
                'disabled' => true,
                'required' => false,
            ])
            ->add('existencia', TextType::class, [
                'required' => false,
                'disabled' => true,
                'attr' => ['class' => 'w-100']
            ])
            ->add('existencia_incremento', TextType::class, [
                'required' => false,
                'label' => 'Exist. + Cant.',
                'disabled' => true,
                'mapped' => false,
                'attr' => ['class' => 'w-100']
            ])
            ->add('id_unidad_medida', EntityType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'UM',
                'class' => UnidadMedida::class,
                'choice_label' => 'abreviatura',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
//                        ->select(array('u.id','u.nombre','u.abreviatura'))
                        ->where('u.activo = true')
                        ->orderBy('u.abreviatura', 'ASC');
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'data_class' => Mercancia::class,
        ]);
    }
}
