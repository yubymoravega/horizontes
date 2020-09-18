<?php

namespace App\Form\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Inventario\Proveedor;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class AjusteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mercancia', MercanciaType::class,[
                'mapped'=>false,
                'auto_initialize'=>true
            ])
            ->add('documento', DocumentoType::class,[
                'mapped'=>false,
                'auto_initialize'=>true
            ])
            ->add('nro_cuenta_inventario', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label'=>'Cuenta de inventario',
                'choice_label' => 'nro_cuenta',
            ))
            ->add('nro_subcuenta_inventario', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label'=>'Subcuenta de inventario',
                'choice_label' => 'nro_subcuenta',
            ))
            ->add('nro_cuenta_acreedora', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label'=>'Cuenta acreedora',
                'choice_label' => 'nro_cuenta',
            ))
            ->add('observacion', TextareaType::class, [
                'label'=>'Observaciones',
                'mapped'=>true,
                'attr' => ['class' => 'w-100']
            ])
            ->add('list_mercancia',HiddenType::class)
        ;
    }
}
