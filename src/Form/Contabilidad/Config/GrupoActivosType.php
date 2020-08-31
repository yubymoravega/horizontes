<?php

namespace App\Form\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\GrupoActivos;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\CoreContabilidad\AuxFunctions;

class GrupoActivosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('porciento_deprecia_anno', NumberType::class)
            ->add('descripcion', TextareaType::class)
            ->add('id_cuenta', EntityType::class, [
                'class' => Cuenta::class,
                'choice_label' => 'nro_cuenta',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nro_cuenta', 'ASC');
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
            'data_class' => GrupoActivos::class,
        ]);
    }
}
