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
        foreach ($unidades as $unidad)
            $choices[$unidad->getNombre()] = $unidad->getId();
        $builder
            ->add('__selected__unidad', ChoiceType::class, [
                'attr' => ['class' => 'mr-2 form-control'],
                'data' => AuxFunctions::getUnidad($this->em, $this->security->getUser())->getId(),
                'choices' => $choices
            ]);
    }

}
