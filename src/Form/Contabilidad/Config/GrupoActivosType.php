<?php

namespace App\Form\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\GrupoActivos;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GrupoActivosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('porciento_deprecia_anno')
            ->add('descripcion',TextareaType::class)
            ->add('id_cuenta', EntityType::class,[
                'mapped'=>false,
                'class'=>Cuenta::class,
                'choice_label'=>'nro_cuenta',
                'query_builder'=>function(EntityRepository $er){
                    return $er->createQueryBuilder('u')
                        ->where('u.activo = true')
                        ->orderBy('u.nro_cuenta','ASC');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GrupoActivos::class,
        ]);
    }
}
