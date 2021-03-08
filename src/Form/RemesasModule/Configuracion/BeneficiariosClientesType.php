<?php

namespace App\Form\RemesasModule\Configuracion;

use App\Entity\Pais;
use App\Entity\RemesasModule\Configuracion\BeneficiariosClientes;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BeneficiariosClientesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('primer_nombre', ChoiceType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Nombre',
            ])
            ->add('monto_entregar', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'A pagar',
            ])
            ->add('monto_recibir', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'A recibir',
            ])
            ->add('primer_apellido', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => '1er Apellido',
            ])
            ->add('nuevo_beneficiario', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Nombre',
            ])
            ->add('segundo_apellido', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => '2do Apellido',
            ])
            ->add('nombre_alternativo', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Nombre Alternativo',
            ])
            ->add('primer_apellido_alternativo', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => '1er Apellido Alternativo',
            ])
            ->add('segundo_apellido_alternativo', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => '2do Apellido Alternativo',
            ])
            ->add('primer_telefono', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Teléfono Principal',
            ])
            ->add('segundo_telefono', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Otro Teléfono',
            ])
            ->add('identificacion', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Identificacion',
            ])
            ->add('calle', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Calle',
            ])
            ->add('entre', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Entre',
            ])
            ->add('y', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Y',
            ])
            ->add('nro_casa', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Nro. Casa',
            ])
            ->add('edificio', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Edificio',
            ])
            ->add('apto', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Apartamento',
            ])
            ->add('reparto', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'w-100'],
                'label' => 'Reparto',
            ])
            ->add('id_pais', EntityType::class, [
                'required' => true,
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
            ->add('id_provincia', ChoiceType::class, [
                'required' => true,
                'attr' => ['class' => 'w-100'],
                'label' => 'Provincia',
            ])
            ->add('id_municipios', ChoiceType::class, [
                'required' => true,
                'attr' => ['class' => 'w-100'],
                'label' => 'Municipio',
            ])
            ->add('id_moneda', ChoiceType::class, [
                'required' => true,
                'attr' => ['class' => 'w-100'],
                'label' => 'Moneda',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BeneficiariosClientes::class,
        ]);
    }
}
