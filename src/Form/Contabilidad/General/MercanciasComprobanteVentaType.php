<?php

namespace App\Form\Contabilidad\General;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Inventario\Expediente;
use App\Entity\Contabilidad\Inventario\OrdenTrabajo;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class  MercanciasComprobanteVentaType extends AbstractType
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
            ->add('cuenta_nominal_acreedora', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Cuentas Nominal Acreedora',
                'choices' => (function () {
                    $cuentas = $this->em->getRepository(Cuenta::class)->findBy(['id_tipo_cuenta' => 14]);
                    $cuentas_obj = [];
                    if (!empty($cuentas)) {
                        foreach ($cuentas as $cuenta) {
                            /** @var Cuenta $cuenta */
                            $cuentas_obj[$cuenta->getNroCuenta() . ' - ' . $cuenta->getNombre()] = $cuenta->getNroCuenta();
                        }
                    }
                    return $cuentas_obj;
                })()
            ])
            ->add('subcuenta_nominal_acreedora', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Subcuentas Nominal Acreedora',
            ])

            ->add('centro_costo_acreedora', EntityType::class, [
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

            ])
            ->add('elemento_gasto_acreedora', EntityType::class, [
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
            ->add('expediente_acreedora', EntityType::class, [
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
            ->add('orden_trabajo_acreedora', EntityType::class, [
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
            ->add('cuenta_costo', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Cuentas de Costo',
                'choices' => (function () {
                    $cuentas = $this->em->getRepository(Cuenta::class)->findBy(['id_tipo_cuenta' => 13]);
                    $cuentas_obj = [];
                    if (!empty($cuentas)) {
                        foreach ($cuentas as $cuenta) {
                            /** @var Cuenta $cuenta */
                            $cuentas_obj[$cuenta->getNroCuenta() . ' - ' . $cuenta->getNombre()] = $cuenta->getNroCuenta();
                        }
                    }
                    return $cuentas_obj;
                })()
            ])
            ->add('subcuenta_costo', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Subcuenta de Costo',
            ])

            ->add('mercancias_productos', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Mercancias y Productos',
            ])
            ->add('centro_costo', EntityType::class, [
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

            ])
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

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
//        $resolver->setDefaults([
//            'data_class' => Factura::class,
//        ]);
    }
}
