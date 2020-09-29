<?php

namespace App\Form\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;

class TransferenciaSalidaType extends AbstractType
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
                'label' => 'Cuenta de deudora',
                'choice_label' => 'nro_cuenta',
            ))
            ->add('nro_subcuenta_inventario', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Subcuenta deudora',
                'choice_label' => 'nro_subcuenta',
            ))
            ->add('id_unidad', ChoiceType::class, [
                'label' => 'Unidad',
                'attr' => ['class' => 'w-100'],
                'choice_label' => 'nombre',
            ])
            ->add('id_almacen', ChoiceType::class, [
                'label' => 'Almacen',
                'attr' => ['class' => 'w-100'],
                'choice_label' => 'descripcion',
            ])
            ->add('list_mercancia', HiddenType::class);
    }
}
