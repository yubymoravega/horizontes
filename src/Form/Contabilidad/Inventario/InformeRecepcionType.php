<?php

namespace App\Form\Contabilidad\Inventario;

use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\Proveedor;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformeRecepcionType extends AbstractType
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
            ->add('nro_cuenta_acreedora', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label'=>'Cuenta acreedora',
                'choice_label' => 'nro_cuenta',
            ))
            ->add('nro_subcuenta_acreedora', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label'=>'Subcuenta acreedora',
                'choice_label' => 'nro_subcuenta',
            ))
            ->add('cod_proveedor', TextType::class, [
                'required' => true,
                'label'=>'Cod. Proveedor',
                'attr' => ['class' => 'w-100'],
            ])
            ->add('nombre_proveedor', TextType::class, [
                'required' => true,
                'label'=>'Proveedor',
                'attr' => ['class' => 'w-100'],
            ])
            ->add('fecha_factura', DateType::class, array(
                'input' => 'datetime',
                'label'=>'Fecha de la factura',
                'attr' => ['class' => 'w-100'],
                'widget' => 'single_text',
                'placeholder' => 'Fecha de la factura'
            ))
            ->add('codigo_factura', TextType::class, [
                'required' => true,
                'attr' => ['class' => 'w-100'],
                'label'=>'Número de factura',
            ])
            ->add('list_mercancia',HiddenType::class)
        ;
    }

//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults([
//            'data_class' => InformeRecepcion::class,
//        ]);
//    }
}
