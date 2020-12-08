<?php

namespace App\Form\Contabilidad\Venta;

use App\Controller\Contabilidad\Venta\IVenta\ClientesAdapter;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\TerminoPago;
use App\Entity\Contabilidad\Venta\ContratosCliente;
use App\Entity\Contabilidad\Venta\Factura;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FacturaType extends AbstractType
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('nro_factura', TextType::class, [
                'attr' => ['class' => 'w-50 form-control form-control-sm mr-2']
            ])
            ->add('ncf', TextType::class, [
                'attr' => ['class' => 'w-100 form-control form-control-sm mr-2', 'readonly' => true],
                'label'=>'NCF'
            ])
            ->add('id_contrato', EntityType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Contratos',
                'class' => ContratosCliente::class,
                'choice_value' => 'id',
                'choice_label' => function (ContratosCliente $contrato) {
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
            ->add('id_moneda', EntityType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Moneda',
                'class' => Moneda::class,
                'choice_value' => 'id',
                'choice_label' => function (Moneda $moneda) {
                    return $moneda->getNombre();
                }
            ])
            ->add('id_termino_pago', EntityType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Término de pago',
                'class' => TerminoPago::class,
                'choice_value' => 'id',
                'choice_label' => function (TerminoPago $tp) {
                    return $tp->getNombre();
                }
            ])
            ->add('anno', HiddenType::class, [
                'data' => Date('Y')
            ]);
    }

    function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Factura::class,
        ]);
    }
}
