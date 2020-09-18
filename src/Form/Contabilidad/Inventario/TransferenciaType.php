<?php

namespace App\Form\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\Contabilidad\Inventario\Transferencia;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;

class TransferenciaType extends AbstractType
{
    private $security;
    private $em_;
    private $id_unidad;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em_ = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->security->getUser();
        $obj_unidad = AuxFunctions::getUnidad($this->em_, $user);
        $this->id_unidad = $obj_unidad->getId();

        $builder
            ->add('mercancia', MercanciaType::class, [
                'mapped' => false,
                'auto_initialize' => true
            ])
            ->add('documento', DocumentoType::class, [
                'mapped' => false,
                'auto_initialize' => true
            ])
            ->add('nro_cuenta_inventario', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Cuenta de inventario',
                'choice_label' => 'nro_cuenta',
            ))
            ->add('nro_subcuenta_inventario', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Subcuenta de inventario',
                'choice_label' => 'nro_subcuenta',
            ))
            ->add('nro_cuenta_acreedora', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Cuenta acreedora',
                'choice_label' => 'nro_cuenta',
            ))
            ->add('id_unidad', EntityType::class, [
                'class' => Unidad::class,
                'label' => 'Unidad',
                'attr' => ['class' => 'w-100'],
                'choice_label' => 'nombre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->andWhere('u.id != :val')
                        ->setParameter('val', $this->id_unidad)
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('id_almacen', EntityType::class, [
                'class' => Almacen::class,
                'label' => 'Almacen',
                'attr' => ['class' => 'w-100'],
                'choice_label' => 'descripcion',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->andWhere('u.id_unidad = :val')
                        ->setParameter('val', $this->id_unidad)
//                        ->andWhere('u.id != :val')
//                        ->setParameter('val', $this->id_almacen)
                        ->orderBy('u.descripcion', 'ASC');
                }
            ])
            ->add('list_mercancia', HiddenType::class);
    }
}
