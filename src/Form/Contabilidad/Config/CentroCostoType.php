<?php

namespace App\Form\Contabilidad\Config;

use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Subcuenta;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\CoreContabilidad\AuxFunctions;

class CentroCostoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('codigo')
            ->add('id_cuenta', EntityType::class, [
                'class' => Cuenta::class,
                'label' => 'Subcuenta',
                'choice_label' => 'descripcion',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.descripcion', 'ASC');
                }
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA,
                function (FormEvent $event) {
                    AuxFunctions::formModifierSubcuenta($event->getForm());
                })
            ->get('id_cuenta')->addEventListener(FormEvents::POST_SUBMIT,
                function (FormEvent $event) {
                    /** @var Cuenta $cuenta */
                    $cuenta = $event->getForm()->getData();
                    $id_cuenta = $cuenta === null ? '' : $cuenta->getId();
                    AuxFunctions::formModifierSubcuenta($event->getForm()->getParent(), $id_cuenta);
                });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CentroCosto::class,
        ]);
    }
}
