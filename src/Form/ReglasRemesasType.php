<?php

namespace App\Form;

use App\Entity\ReglasRemesas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReglasRemesasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('idMonedaPais')
            ->add('desde')
            ->add('hasta')
            ->add('tarifa',ChoiceType::class, [
                'choices' => [
                    'Porciento %' => 'porciento',
                    'Fija' => 'fija',
                    'Tarifa' => null,
                ],])
            ->add('valor')
            ->add('estado',ChoiceType::class, [
                'choices' => [
                    'Activado' => '1',
                    'Desactivado' => '0',
                    'Estado' => null,
                ],])
                ->add('Guardar', SubmitType::class, [
                    'attr' => ['class' => 'btn btn-sm btn-outline-dark']])
            ;    
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReglasRemesas::class,
        ]);
    }
}
