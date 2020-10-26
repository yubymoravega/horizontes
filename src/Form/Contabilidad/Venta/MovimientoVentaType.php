<?php

namespace App\Form\Contabilidad\Venta;

use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Venta\MovimientoVenta;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MovimientoVentaType extends AbstractType
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mercancia', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Tipo',
                'choices' => [
                    'Mercancía' => 1,
                    'Producto' => 2
                ]
            ])
            ->add('codigo')
            ->add('descripcion', TextType::class, [
                'attr' => ['class' => 'w-100', 'readonly' => true],
            ])
            ->add('um', TextType::class, [
                'attr' => ['class' => 'w-100', 'readonly' => true]
            ])
            ->add('cantidad', NumberType::class, [
                'attr' => ['class' => 'w-100']
            ])
            ->add('precio', NumberType::class, [
                'attr' => ['class' => 'w-100']
            ])
            ->add('descuento_recarga', NumberType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Descuento/Recarga'
            ])
            ->add('existencia', NumberType::class, [
                'attr' => ['class' => 'w-100', 'readonly' => true]
            ])
            ->add('cuenta_deudora', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Cuentas deudora',
                'choices' => (function () {
                    $cuentas = $this->em->getRepository(Cuenta::class)->findBy(['obligacion_acreedora' => true]);
                    $cuentas_obj = [];
                    if (!empty($cuentas)) {
                        foreach ($cuentas as $cuenta) {
                            /** @var Cuenta $cuenta */
                            $cuentas_obj[$cuenta->getNroCuenta() .' - '. $cuenta->getNombre()] = $cuenta->getNroCuenta();
                        }
                    }
//                    dd($cuentas_obj);
                    return $cuentas_obj;
                })()
            ])
            /*->add('cuenta_deudora', EntityType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Cuentas deudora',
                'class' => Cuenta::class,
                'choice_value' => 'nro_cuenta',
                'choice_label' => function (Cuenta $value) {
                    return $value->getNroCuenta() . ' - ' . $value->getNombre();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->andWhere('u.obligacion_acreedora = true');
                },
            ])*/
            ->add('subcuenta_deudora', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
            ])
            ->add('cuenta_acreedora', EntityType::class, [
                'attr' => ['class' => 'w-100'],
                'label' => 'Cuentas acreedora',
                'class' => Cuenta::class,
                'choice_value' => 'nro_cuenta',
                'choice_label' => function (Cuenta $value) {
                    return $value->getNroCuenta() . ' - ' . $value->getNombre();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->andWhere('u.obligacion_deudora = true');
                },
            ])
            ->add('subcuenta_acreedora', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
            ]);
    }

    /*public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MovimientoVenta::class,
        ]);
    }*/
}
