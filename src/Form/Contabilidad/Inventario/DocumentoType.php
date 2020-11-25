<?php

namespace App\Form\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Inventario\Documento;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cantidad_mercancia', TextType::class, [
                'required' => false,
                'label' => 'Cantidad',
                'attr' => ['class' => 'w-100']
            ])
            ->add('importe_mercancia', TextType::class, [
                'required' => false,
                'label' => 'Importe',
                'attr' => ['class' => 'w-100']
            ])
            ->add('id_moneda', ChoiceType::class, array(
                'attr' => ['class' => 'w-100'],
                'label'=>'Moneda',
                'choice_label' => 'nombre'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //  'data_class' => Documento::class,
        ]);
    }
}
