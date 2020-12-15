<?php

namespace App\Form\Contabilidad\General;

use App\Controller\Contabilidad\Venta\IVenta\ClientesAdapter;
use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Inventario\Expediente;
use App\Entity\Contabilidad\Inventario\OrdenTrabajo;
use App\Entity\Contabilidad\Inventario\Proveedor;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class CuentasComprobanteOperacionesType extends AbstractType
{
    private EntityManagerInterface $em;
    private $security;
    private $id_unidad;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->security = $security;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->security->getUser();
        $obj_unidad = AuxFunctions::getUnidad($this->em, $user);
        $this->id_unidad = $obj_unidad->getId();

        $builder
            ->add('centro_costo', EntityType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Centro de costo',
                'class' => CentroCosto::class,
                'choice_value' => 'id',
                'choice_label' => function (CentroCosto $eg) {
                    return $eg->getCodigo() . ' - ' . $eg->getNombre();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->andWhere('u.id_unidad = :val')
                        ->setParameter('val', $this->id_unidad);
                }
            ))
            ->add('elemento_gasto', EntityType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Elemento de gasto',
                'class' => ElementoGasto::class,
                'choice_value' => 'id',
                'choice_label' => function (ElementoGasto $eg) {
                    return $eg->getCodigo() . ' - ' . $eg->getDescripcion();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true');
                }
            ])
            ->add('almacen', EntityType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Almacén',
                'class' => Almacen::class,
                'choice_value' => 'id',
                'choice_label' => function (Almacen $eg) {
                    return $eg->getCodigo() . ' - ' . $eg->getDescripcion();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->andWhere('u.id_unidad = :val')
                        ->setParameter('val', $this->id_unidad);
                }
            ))
            ->add('nro_cuenta', EntityType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Cuenta',
                'class' => Cuenta::class,
                'choice_value' => 'id',
                'choice_label' => function (Cuenta $eg) {
                    return $eg->getNroCuenta() . ' - ' . $eg->getNombre();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true');
                }
            ])
            ->add('nro_subcuenta', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Subcuenta',
                'choice_label' => 'subcuenta',
            ))
            ->add('id_factura',TextType::class, [
                'attr' => ['class' => 'w-100'],
                'disabled' => true
            ])
            ->add('id_informe_recepcion',TextType::class, [
                'attr' => ['class' => 'w-100'],
                'disabled' => true
            ])
            ->add('expediente', EntityType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Expediente',
                'class' => Expediente::class,
                'choice_value' => 'id',
                'choice_label' => function (Expediente $eg) {
                    return $eg->getCodigo() . ' - ' . $eg->getDescripcion();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->andWhere('u.id_unidad = :val')
                        ->setParameter('val', $this->id_unidad);
                }
            ])
            ->add('orden_trabajo', EntityType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Orden de trabajo',
                'class' => OrdenTrabajo::class,
                'choice_value' => 'id',
                'choice_label' => function (OrdenTrabajo $eg) {
                    return $eg->getCodigo() . ' - ' . $eg->getDescripcion();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->andWhere('u.id_unidad = :val')
                        ->setParameter('val', $this->id_unidad);
                }
            ])
            ->add('unidad', EntityType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Unidad',
                'class' => Unidad::class,
                'choice_value' => 'id',
                'choice_label' => function (Unidad $eg) {
                    return $eg->getCodigo() . ' - ' . $eg->getNombre();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->andWhere('u.id = :val')
                        ->setParameter('val', $this->id_unidad);
                }
            ))->add('tipo_cliente', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Tipo cliente',
                'choices' => ClientesAdapter::getTypeClientes()
            ])
            ->add('cliente', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
                'choice_value' => 'id',
                'label' => 'Cliente',
            ])
            ->add('proveedor', EntityType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Proveedor',
                'class' => Proveedor::class,
                'choice_value' => 'id',
                'choice_label' => function (Proveedor $eg) {
                    return $eg->getCodigo() . ' - ' . $eg->getNombre();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true');
                }
            ))
            ->add('debito', NumberType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Débito',
            ])
            ->add('credito', NumberType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Crédito',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
