<?php

namespace App\Form\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElementoGastoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo')
            ->add('descripcion', null, [
                'required' => true
            ])
            ->add('id_cuenta', EntityType::class, [
                'class' => Cuenta::class,
                'choice_label' => 'descripcion',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->andWhere('u.elemento_gasto = true')
                        ->orderBy('u.descripcion', 'ASC');
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ElementoGasto::class,
        ]);
    }
}
