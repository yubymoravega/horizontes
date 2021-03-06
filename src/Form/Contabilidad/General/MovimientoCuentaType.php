<?php

namespace App\Form\Contabilidad\General;

use App\Controller\Contabilidad\Venta\IVenta\ClientesAdapter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovimientoCuentaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('centro_costo', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Centro costo',
                'choice_label' => 'codigo',
            ))
            ->add('elemento_gasto', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Elemento de gasto',
                'choice_label' => 'codigo',
            ))
            ->add('almacen', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Almacén',
                'choice_label' => 'almacen',
            ))
            ->add('nro_cuenta', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Cuenta',
                'choice_label' => 'cuenta',
            ))
            ->add('nro_subcuenta', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Subcuenta',
                'choice_label' => 'subcuenta',
            ))
            ->add('expediente', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Expediente',
                'choice_label' => 'expediente',
            ))
            ->add('orden_trabajo', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Orden de Trabajo',
                'choice_label' => 'orden_trabajo',
            ))
            ->add('unidad', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Unidad',
                'choice_label' => 'unidad',
            ))
            ->add('tipo_cliente', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Tipo cliente',
                'choices' => ClientesAdapter::getTypeClientes()
            ])
            ->add('id_cliente', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
                'choice_value' => 'id',
                'label' => 'Cliente',
            ])
            ->add('proveedor', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Proveedor',
                'choice_label' => 'proveedor',
            ))
            ->add('periodo', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Período'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
