<?php

namespace App\Form\Contabilidad\ActivoFijo;

use App\Entity\Contabilidad\ActivoFijo\ActivoFijo;
use App\Entity\Contabilidad\Config\AreaResponsabilidad;
use App\Entity\Contabilidad\Config\GrupoActivos;
use App\Entity\Contabilidad\Config\TipoMovimiento;
use App\Entity\Contabilidad\Config\Unidad;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivoFijoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nro_inventario')
            ->add('fecha_alta',DateType::class, array(
                'input'=>'datetime',
                'widget'=>'single_text',
                'placeholder'=>'Fecha',
            ))
            ->add('fecha_ultima_depreciacion',DateType::class, array(
                'input'=>'datetime',
                'widget'=>'single_text',
                'placeholder'=>'Fecha ultima depreciacion',
            ))
            ->add('descripcion')
            ->add('valor_inicial')
            ->add('depreciacion_acumulada')
            ->add('valor_real')
            ->add('annos_vida_util')
            ->add('pais', ChoiceType::class)
            ->add('modelo')
            ->add('tipo')
            ->add('marca')
            ->add('nro_motor')
            ->add('nro_serie')
            ->add('nro_chapa')
            ->add('nro_chasis')
            ->add('combustible')
            ->add('id_area_responsabilidad', ChoiceType::class)
            ->add('id_grupo_activo', ChoiceType::class)
            ->add('activo_fijo_cuentas',ActivoFijoCuentasType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ActivoFijo::class,
        ]);
    }
}
