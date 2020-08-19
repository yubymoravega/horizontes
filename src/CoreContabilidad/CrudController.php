<?php


namespace App\CoreContabilidad;

use App\Form\Contabilidad\Config\CrudEditDescripcionType;
use App\Form\Contabilidad\Config\CrudEditNameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CrudController
 * @package App\CoreContabilidad
 * Steps
 * 1- validar en la Entity  @UniqueEntity("nombre" | "descripcion")
 *                          @Assert\NotBlank(message="contabilidad.config.descripcion_not_blank")
 * 2- crear el controlador con los metodos CRUD eredeadaos e inisializados
 * 3- actualizar las configuraciones del __constructor del NameController
 * 4- crear el 'adicionar', SubmitType::class -- en el formulario NameType
 */
class CrudController extends AbstractController
{
    private string $label;

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    private string $title;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    private string $class_type_name;

    /**
     * @return string
     */
    public function getClassTypeName(): string
    {
        return $this->class_type_name;
    }

    /**
     * @param string $class_type_name
     */
    public function setClassTypeName(string $class_type_name): void
    {
        $this->class_type_name = $class_type_name;
    }

    private string $class_entity;

    /**
     * @return string
     */
    public function getClassEntity(): string
    {
        return $this->class_entity;
    }

    /**
     * @param string $class_entity
     */
    public function setClassEntity(string $class_entity): void
    {
        $this->class_entity = $class_entity;
    }

    /**
     * @return string
     */
    public function getIndexTwig(): string
    {
        return $this->index_twig;
    }

    /**
     * @param string $index_twig
     */
    public function setIndexTwig(string $index_twig): void
    {
        $this->index_twig = $index_twig;
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @param array $messages
     */
    public function setMessages(array $messages): void
    {
        $this->messages = $messages;
    }

    private string $index_twig;
    private array $messages;
    private array $paths;

    /**
     * @return array
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

    /**
     * @param array $paths
     */
    public function setPaths(array $paths): void
    {
        $this->paths = $paths;
    }

    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm($this->class_type_name);
        $form->handleRequest($request);
        $errors = null;

        if ($form->isSubmitted()) {

            $instance = $form->getData();
            $errors = $validator->validate($instance);

            if ($form->isValid()) {
                $instance->setActivo(true);
                $em->persist($instance);
                $em->flush();
                $this->addFlash('success', $this->messages['add']);
                $form = $this->createForm($this->class_type_name);
            }
        }

        if ($errors) {
            foreach ($errors as $error) {
                /** @var ConstraintViolation $error */
                $this->addFlash('error', $error->getMessage());
            }
        }

        //list
        $arr_list = $em->getRepository($this->class_entity)->findByActivo(true);
        return $this->render('contabilidad/config/CRUD/index_crud_name.html.twig', [
            'title' => $this->title,
            'label' => $this->label,
            'paths' => $this->paths,
            'list' => $arr_list,
            'form' => $form->createView()
        ]);
    }

    public function Update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        $current_instance = $em->getRepository($this->class_entity)->find($id);
        if (!$current_instance) {
            $this->addFlash('error', $this->messages['not_exist']);
            return $this->redirectToRoute($this->paths['index']);
        }

        if ($request->isMethod(Request::METHOD_GET))
            $form = $this->createForm(
                $this->label === 'nombre' ?
                    CrudEditNameType::class :
                    CrudEditDescripcionType::class,
                $current_instance, ['data_class' => $this->class_entity]);
        else
            $form = $this->createForm(
                $this->label === 'nombre' ?
                    CrudEditNameType::class :
                    CrudEditDescripcionType::class,
                null, ['data_class' => $this->class_entity]);

        $form->handleRequest($request);
        $errors = null;

        if ($form->isSubmitted()) {
            $instance = $form->getData();
            $errors = $validator->validate($instance);

            if ($form->isValid()) {
                if ($this->label === 'nombre') $current_instance->setNombre($instance->getNombre());
                else $current_instance->setDescripcion($instance->getDescripcion());
                $em->flush();
                $this->addFlash('success', $this->messages['edit']);
                return $this->redirectToRoute($this->paths['index']);
            }
        }

        if ($errors) {
            foreach ($errors as $error) {
                /** @var ConstraintViolation $error */
                $this->addFlash('error', $error->getMessage());
            }
        }

        //list
        $arr_list = $em->getRepository($this->class_entity)->findByActivo(true);
        return $this->render('contabilidad/config/CRUD/update_crud_name.html.twig', [
            'title' => $this->title,
            'descrip' => $this->label === 'nombre' ? $current_instance->getNombre() : $current_instance->getDescripcion(),
            'label' => $this->label,
            'paths' => $this->paths,
            'list' => $arr_list,
            'form' => $form->createView()
        ]);
    }

    public function Delete(EntityManagerInterface $em, $id)
    {
        $instance = $em->getRepository($this->class_entity)->find($id);
        if ($instance) {
            $instance->setActivo(false);
            $em->persist($instance);
            $em->flush();
            $this->addFlash('success', $this->messages['delete']);
        } else
            $this->addFlash('error', 'El Almacén no pudo ser eliminado');
        return $this->redirectToRoute($this->paths['index']);
    }
}