<?php

namespace App\Form\Contabilidad\Venta;

use App\Controller\Contabilidad\Venta\IVenta\ClientesAdapter;
use App\Controller\Contabilidad\VentaController;
use App\Entity\Contabilidad\Venta\ContratosCliente;
use App\Entity\Contabilidad\Venta\Factura;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FacturaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha_factura', DateType::class, [
                'input' => 'datetime',
                'label' => 'Fecha de la factura',
                'attr' => ['class' => 'w-100'],
                'widget' => 'single_text',
            ])
            ->add('tipo_cliente', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Tipo cliente',
                'choices' => ClientesAdapter::getTypeClientes()
            ])
            ->add('id_cliente', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Cliente',
            ])
            /* ->add('nro_factura', TextType::class, [
                 'attr' => ['class' => 'w-25']
             ])*/
            ->add('id_contrato', EntityType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Contratos',
                'class' => ContratosCliente::class,
                'choice_label' => function ($contrato) {
                    return $contrato->getNroContrato() . ' - '
                        . $contrato->getIdCliente()->getNombre() . ' | $'
                        . $contrato->getImporte() . ' ( '
                        . $contrato->getFechaAprobado()->format('d/m/Y') . ' )';
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true');
                },

            ])
            ->add('cuenta_obligacion', ChoiceType::class, [

            ])
            ->add('subcuenta_obligacion')
            ->add('movimiento_venta', MovimientoVentaType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Factura::class,
        ]);
    }
}
