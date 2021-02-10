<?php

namespace App\Form\Contabilidad\Venta;

use App\Entity\Contabilidad\Config\Banco;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Venta\CuentasCliente;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CuentasClienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nro_cuenta',TextType::class,array(
                'required' => true,
                'label'=>'Nro. cuenta',
                'attr' => ['class' => 'w-100'],
            ))
            ->add('id_moneda',EntityType::class,[
                'attr' => ['class' => 'w-100'],
                'label'=>'Moneda',
                'required' => true,
                'class' => Moneda::class,
                'choice_label' => 'nombre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('id_banco',EntityType::class,[
                'attr' => ['class' => 'w-100'],
                'label'=>'Banco',
                'required' => true,
                'class' => Banco::class,
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
            'data_class' => CuentasCliente::class,
        ]);
    }
}
