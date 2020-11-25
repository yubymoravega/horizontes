<?php

namespace App\Form\Contabilidad\Venta;

use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Venta\ClienteContabilidad;
use App\Entity\Contabilidad\Venta\ContratosCliente;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratosClienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nro_contrato', null, [
                'label' => 'Nro. Contrato',
            ])
            ->add('fecha_aprobado', DateType::class, [
                'input' => 'datetime',
                'label' => 'Fecha de aprobación',
                'attr' => ['class' => 'w-100'],
                'widget' => 'single_text',
                'placeholder' => 'Fecha de aprobación'
            ])
            ->add('fecha_vencimiento', DateType::class, [
                'input' => 'datetime',
                'label' => 'Fecha de vencimiento',
                'attr' => ['class' => 'w-100'],
                'widget' => 'single_text',
                'placeholder' => 'Fecha de vencimiento'
            ])
            ->add('importe', NumberType::class, [
                'label' => 'Importe',
            ])
            ->add('id_cliente', EntityType::class, [
                'class' => ClienteContabilidad::class,
                'label' => 'Cliente',
                'choice_label' => 'nombre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('id_moneda', EntityType::class, [
                'class' => Moneda::class,
                'choice_label' => 'nombre',
                'label' => 'Moneda',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre', 'ASC');
                }
            ])
            ->add('aceptar', SubmitType::class, ['attr'=> ['class' => 'btn btn-secondary']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContratosCliente::class,
        ]);
    }
}
