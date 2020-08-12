<?php

namespace App\Form\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\TasaCambio;
use Doctrine\DBAL\Types\DecimalType;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TasaCambioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anno', NumberType::class)
            ->add('mes',ChoiceType::class,[
                'choices'=>[
                    'Enero'=>1,
                    'Febrero'=>2,
                    'Marzo'=>3,
                    'Abril'=>4,
                    'Mayo'=>5,
                    'Junio'=>6,
                    'Julio'=>7,
                    'Agosto'=>8,
                    'Septiembre'=>9,
                    'Octubre'=>10,
                    'Noviembre'=>11,
                    'Diciembre'=>12,
                ]
            ])
            ->add('valor',NumberType::class)
            ->add('id_moneda_origen', EntityType::class,[
                'mapped'=>false,
                'class'=>Moneda::class,
                'choice_label'=>'nombre',
                'query_builder'=>function(EntityRepository $er){
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre','ASC');
                }
            ])
            ->add('id_moneda_destino',EntityType::class,[
                'mapped'=>false,
                'class'=>Moneda::class,
                'choice_label'=>'nombre',
                'query_builder'=>function(EntityRepository $er){
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre','ASC');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TasaCambio::class,
        ]);
    }
}
