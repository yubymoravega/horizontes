<?php

namespace App\Form\Contabilidad\Venta;

use App\Entity\Contabilidad\Config\CategoriaCliente;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Venta\ClienteContabilidad;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClienteContabilidadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo', TextType::class, array(
                'required' => true,
                'label' => 'NRF',
                'attr' => ['class' => 'w-100 '],
            ))
            ->add('nombre', TextType::class, array(
                'required' => true,
                'label' => 'Nombre',
                'attr' => ['class' => 'w-100 '],
            ))
            ->add('telefonos', TextType::class, array(
                'required' => true,
                'label' => 'Telefonos',
                'attr' => ['class' => 'w-100'],
            ))
            ->add('fax', TextType::class, array(
                'required' => false,
                'label' => 'Fax',
                'attr' => ['class' => 'w-100'],
            ))
            ->add('correos', TextType::class, array(
                'required' => true,
                'label' => 'Correos',
                'attr' => ['class' => 'w-100', 'placeholder' => 'usuario@dominio.com - usuario@dominio.com'],
            ))
            ->add('direccion', TextareaType::class, array(
                'required' => true,
                'label' => 'Dirección',
                'attr' => ['class' => 'w-100'],
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClienteContabilidad::class,
        ]);
    }
}
