<?php

namespace App\Form\Contabilidad\Config;

use App\Entity\Contabilidad\Config\ConfiguracionInicial;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Modulo;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoDocumento;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfiguracionInicialType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('id_modulo',EntityType::class,[
                'mapped'=>false,
                'class'=>Modulo::class,
                'choice_label'=>'nombre',
                'query_builder'=>function(EntityRepository $er){
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre','ASC');
                }
            ])
            ->add('id_tipo_documento',EntityType::class,[
                'mapped'=>false,
                'class'=>TipoDocumento::class,
                'choice_label'=>'nombre',
                'query_builder'=>function(EntityRepository $er){
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nombre','ASC');
                }
            ])
//            ->add('id_cuenta',EntityType::class,[
//                'mapped'=>false,
//                'class'=>Cuenta::class,
//                'choice_label'=>'nro_cuenta',
//                'query_builder'=>function(EntityRepository $er){
//                    return $er->createQueryBuilder('u')
//                        ->where('u.activo = true')
//                        ->orderBy('u.nro_cuenta','ASC');
//                }
//            ])
            ->add('aceptar', SubmitType::class, ['attr'=> ['class' => 'btn btn-secondary']])
            ->add('aplicar', SubmitType::class, ['attr'=> ['class' => 'btn btn-secondary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ConfiguracionInicial::class,
        ]);
    }
}
