<?php

namespace App\Form\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;

class DevolucionType extends AbstractType
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
            ->add('nro_subcuenta_acreedora', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Subcuenta acreedora',
                'choice_label' => 'nro_subcuenta',
            ))
            ->add('nro_cuenta_acreedora', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Cuenta acreedora',
                'choice_label' => 'nro_cuenta',
            ))
            ->add('id_centro_costo', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Centro costo',
                'choice_label' => 'codigo',
            ))
            ->add('id_elemento_gasto', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Elemento de gasto',
                'choice_label' => 'codigo',
            ))
            ->add('cod_ot', TextType::class, array(
                'attr' => ['class' => 'w-100'],
                'label' => 'Código OT'
            ))
            ->add('desc_ot', TextType::class, array(
                'attr' => ['class' => 'w-100', 'readonly'=>true],
                'label' => 'Descripción OT'
            ))
            ->add('list_mercancia', HiddenType::class);
    }
}
