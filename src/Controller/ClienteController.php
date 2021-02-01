<?php

namespace App\Controller;

use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Cliente;
use App\Form\ClienteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;


class ClienteController extends AbstractController
{

    public $apiKey = 'sk_test_szvCvPRPHBF2sWZFxRWCp5hT';

    /**
     * @Route("/cliente-index", name="cliente-index")
     */
    public function clienteIndex(Request $request)
    {

        $data = $this->getDoctrine()
            ->getRepository(Cliente::class)
            ->findOneBy(['telefono' => $request->get('tel')]);

        if ($data) {

            return $this->redirectToRoute('cliente-edit', ['tel' => $request->get('tel')]);
        } else {

            return $this->redirectToRoute('registrar-cliente', ['tel' => $request->get('tel')]);
        }
    }


    /**
     * @Route("/registrar-cliente/{tel}", name="registrar-cliente")
     */
    public function registrarCliente(Request $request, $tel)
    {

        $cliente = new Cliente();

        $cliente->setTelefono($tel);

        $formulario = $this->createForm(
            ClienteType::class,
            $cliente,
            array('action' => $this->generateUrl('registrar-cliente', array('tel' => $tel)), 'method' => 'POST')
        );

        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $dataBase = $this->getDoctrine()->getManager();

            $dataBase->persist($cliente);
            $dataBase->flush();

            $this->addFlash(
                'success',
                'Cliente Agregado'
            );

            return $this->redirectToRoute('categorias', ['tel' => $tel]);
        } else {

            return $this->render('cliente/registrar.html.twig', [
                'formulario' => $formulario->createView()
            ]);
        }
    }

    /**
     * @Route("/cliente-edit/{tel}", name="cliente-edit")
     */
    public function clienteEdit(Request $request, $tel)
    {
        $email = true;

        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(Cliente::class)->findBy(['telefono' => $tel]);

        if (!$data[0]->getCorreo()) {
            $email = false;
        }

        $formulario = $this->createForm(
            ClienteType::class,
            $data[0],
            array('action' => $this->generateUrl('edit-save', array('tel' => $tel)), 'method' => 'PUT')
        );

        return $this->render('cliente/editar.html.twig', [
            'formulario' => $formulario->createView(), 'disabled' => true, 'email' => $email
        ]);
    }

    /**
     * @Route("/edit-save/{tel}", name="edit-save")
     */
    public function editSave($tel, Request $request)
    {
        $stripe = new \Stripe\StripeClient(
            $this->apiKey
        );

        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(Cliente::class)->findBy(['telefono' => $tel]);

        /***
         * Eliminar el registro de la tabla temporal de trabajo del usuario y
         * volverlo a crear con los datos del cliente actualizados
         * develop by Camilo
         ***/
        $update_table = AuxFunctionsTurismo::ActualizarDatosEmpleado($dataBase,$data[0],$this->getUser());

        $formulario = $this->createForm(ClienteType::class, $data[0]);
        $formulario->handleRequest($request);

        if (isset($_POST['cliente']['apellidos'])) {
            $data[0]->setApellidos($_POST['cliente']['apellidos']);
            $dataBase->persist($data[0]);
            $dataBase->flush();
        }

        if (isset($_POST['cliente']['comentario'])) {
            $data[0]->setComentario($_POST['cliente']['comentario']);
            $dataBase->persist($data[0]);
            $dataBase->flush();
        }

        if (isset($_POST['cliente']['direccion'])) {
            $data[0]->setDireccion($_POST['cliente']['direccion']);
            $dataBase->persist($data[0]);
            $dataBase->flush();
        }

        if (isset($_POST['cliente']['nombre'])) {
            $data[0]->setNombre($_POST['cliente']['nombre']);
            $dataBase->persist($data[0]);
            $dataBase->flush();
        }

        if (isset($_POST['cliente']['correo'])) {
            $data[0]->setCorreo($_POST['cliente']['correo']);
            $dataBase->persist($data[0]);
            $dataBase->flush();
        }

        if ($data[0]->getToken()) {
            if ($data[0]->getCorreo()) {
                $stripe->customers->update(
                    $data[0]->getToken(),
                    ['email' => $data[0]->getCorreo(),
                        'name' => $data[0]->getNombre() . $data[0]->getApellidos(),
                        'phone' => $data[0]->getTelefono()]
                );
            }

        }

        $this->addFlash(
            'success',
            'Cliente Editado'
        );

        return $this->redirectToRoute('categorias', ['tel' => $tel]);
    }
}
