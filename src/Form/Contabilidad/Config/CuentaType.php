<?php

namespace App\Form\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\TipoCuenta;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CuentaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nro_cuenta', TextType::class, [
                'label' => 'Nro. cuenta',
            ])
            ->add('nombre', TextareaType::class, [
                'label' => 'Nombre',
            ])
            ->add('deudora', ChoiceType::class, [
                'choices' => ['Deudora' => 1, 'Acreedora' => 0, 'Mixta' => 2],
                'label' => 'Naturaleza',
            ])
            ->add('obligacion_deudora', CheckboxType::class, [
                'required' => false,
                'attr' => ['class' => 'mt-1'],
                'label' => 'Obligación deudora',
            ])
            ->add('produccion', CheckboxType::class, [
                'required' => false,
                'attr' => ['class' => 'mt-1'],
                'label' => 'Producción',
            ])
            ->add('obligacion_acreedora', CheckboxType::class, [
                'required' => false,
                'attr' => ['class' => 'mt-1'],
                'label' => 'Obligación acreedora',
            ])
            ->add('id_tipo_cuenta', EntityType::class, [
                'class' => TipoCuenta::class,
                'label' => 'Tipo de cuenta',
                'choice_label' => 'nombre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cuenta::class,
        ]);
    }
}
