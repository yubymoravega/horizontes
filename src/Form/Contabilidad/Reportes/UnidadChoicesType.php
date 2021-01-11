<?php

namespace App\Form\Contabilidad\Reportes;

use App\CoreContabilidad\AuxFunctions;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Security;

class UnidadChoicesType extends AbstractType
{
    private $em;
    private $security;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $unidades = AuxFunctions::getUnidades($this->em, $this->security->getUser());
        $choices = [];
//        dd($unidades);
        foreach ($unidades as $unidad)
            $choices[$unidad->getNombre()] = $unidad->getId();
//        dd($choices);
        $builder
            ->add('id_cliente', ChoiceType::class, [
                'attr' => ['class' => 'w-100'],
                'choices' => $choices
            ]);
        /*->add('buscar', ButtonType::class, [

        ]);*/
        /*->add('id_unidad', EntityType::class, [
            'class' => Unidad::class,
            'choice_label' => 'nombre',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->where('u.activo = true')
                    ->orderBy('u.nombre', 'ASC');
            }
        ]);*/
    }

}
