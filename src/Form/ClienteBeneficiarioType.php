<?php

namespace App\Form;
use App\Entity\Provincias;
use App\Entity\ClienteBeneficiario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ClienteBeneficiarioType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('idCliente')
            ->add('primerNombre')
            ->add('telefonoCasa')
            ->add('primerApellido')
            ->add('segundoApellido')
            ->add('alternativoNombre')
            ->add('alternativoApellido')
            ->add('telefono')
            ->add('identificacion')
            ->add('calle')
            ->add('no')
            ->add('entre')
            ->add('y')
            ->add('apto')
            ->add('edificio')
            ->add('reparto')
            //->add('municipio')
            ->add('alternativoSegundoApellido')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClienteBeneficiario::class,
        ]);
    }
}
