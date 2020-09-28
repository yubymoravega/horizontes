<?php

namespace App\Controller;

use \Datetime;
use App\Form\ReglasRemesasType;
use App\Entity\Cliente;
use App\Entity\Carrito;
use App\Entity\Provincias;
use App\Entity\Municipios;
use App\Entity\Pais;
use App\Entity\ReglasRemesas;
use App\Entity\MonedaPais; 
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\ClienteBeneficiario;
use App\Form\ClienteBeneficiarioType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class RemesasController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        // 3. Update the value of the private entityManager variable through injection
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/remesas.add/{tel}", name="remesas.add")
     */
    public function add($tel, Request $request)
    {
        $ClienteBeneficiario = new ClienteBeneficiario();

        $dataBase = $this->getDoctrine()->getManager();

        $provincias = $dataBase->getRepository(Provincias::class)->findAll();
        $municipios = $dataBase->getRepository(Municipios::class)->findAll();

        $ClienteBeneficiario->setIdCliente($tel);

        $formulario = $this->createForm(
            ClienteBeneficiarioType::class,
            $ClienteBeneficiario,
            array('action' => $this->generateUrl('remesas.add', array('tel' => $tel)), 'method' => 'POST')
        );

        $formulario->handleRequest($request);

        if ($formulario->isSubmitted()) {
            //$dataBase = $this->getDoctrine()->getManager();

            $ClienteBeneficiario->setProvincia($_POST["provincias"]);
            $ClienteBeneficiario->setMunicipio($_POST["municipios"]);

            $dataBase->persist($ClienteBeneficiario);
            $dataBase->flush();

            $this->addFlash(
                'success',
                'Agregado'
            );

            return $this->redirectToRoute('remesas.beneficiarios', ['tel' => $tel]);
        } else {

            return $this->render('remesas/add-beneficiario.html.twig', [
                'formulario' => $formulario->createView(), 'provincias' => $provincias, 'municipios' => $municipios,
                'provinciaSelect' => false,
                'municipioSelect' => false
            ]);
        }
    }


    /**
     * @Route("/remesas.edit/{id}", name="remesas.edit")
     */
    public function edit($id, Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $ClienteBeneficiario = $dataBase->getRepository(ClienteBeneficiario::class)->find($id);

        $provincias = $dataBase->getRepository(Provincias::class)->findAll();
        $municipios = $dataBase->getRepository(Municipios::class)->findAll();

        //$ClienteBeneficiario->setIdCliente($tel);

        $formulario = $this->createForm(
            ClienteBeneficiarioType::class,
            $ClienteBeneficiario,
            array('action' => $this->generateUrl('remesas.edit', array('id' => $ClienteBeneficiario->getId())), 'method' => 'POST')
        );

        $formulario->handleRequest($request);

        if ($formulario->isSubmitted()) {
            // $dataBase = $this->getDoctrine()->getManager();
            // $dataBase->persist($ClienteBeneficiario);

            $ClienteBeneficiario->setProvincia($_POST["provincias"]);
            $ClienteBeneficiario->setMunicipio($_POST["municipios"]);
            $dataBase->flush();
            $this->addFlash(
                'success',
                'Editado'
            );

            return $this->redirectToRoute('remesas.beneficiarios', ['tel' => $ClienteBeneficiario->getIdCliente()]);
            } else {
               
            return $this->render('remesas/add-beneficiario.html.twig', [
                'formulario' => $formulario->createView(), 'provincias' => $provincias,
                'provinciaSelect' => $ClienteBeneficiario->getProvincia(),
                'municipioSelect' => $ClienteBeneficiario->getMunicipio()
            ]);
        }
    }

    /**
     * @Route("/remesas.beneficiarios/{tel}", name="remesas.beneficiarios")
     */
    public function beneficiarios($tel, EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {
        $dql = "SELECT a FROM App:ClienteBeneficiario a JOIN App:Cliente b WHERE  a.idCliente =$tel";

        $dql .= " ORDER BY a.primerNombre DESC";
        $query = $em->createQuery($dql);

        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(Cliente::class)->findBy(['telefono' => $tel]);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        $user =  $this->getUser();
        $moneda = $dataBase->getRepository(Moneda::class)->find($user->getIdMoneda());

        return $this->render(
            'remesas/beneficiarios.html.twig',
            ['moneda' => $moneda, 'pagination' => $pagination, 'id' =>  $data[0]->getTelefono(), 'nombre' =>  $data[0]->getNombre(), 'apellido' => $data[0]->getApellidos()]
        );
    }

    /**
     * @Route("/remesas.beneficiarios.delete/{id}/{tel}", name="remesas.beneficiarios.delete")
     */
    public function delete($id, $tel, Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(ClienteBeneficiario::class)->findBy(['idCliente' => $id, 'telefono' => $tel]);

        $dataBase->remove($data[0]);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Borrado'
        );

        return $this->redirectToRoute('remesas.beneficiarios', ['tel' => $id]);
    }

    /**
     * @Route("/remesas.municipios", name="remesas.municipios")
     */
    public function municipios(Request $request, EntityManagerInterface $em)
    {

        $code = $request->get('code');
        $dql = "SELECT a FROM App:Municipios a WHERE a.code LIKE '$code%'";
        $query = $em->createQuery($dql);
        $result = $query->getResult();

        $json = null;
        $con = count($result);
        $contador = 0;

        while ($contador < $con) {

            $json[$contador] = array(
                'code' => $result[$contador]->getCode(),
                'nombre' => $result[$contador]->getNombre()
            );
            $contador++;
        }

        return new response(\json_encode($json));
    }

    /**
     * @Route("/remesas.dialog", name="remesas.dialog")
     */
    public function dialog(Request $request, EntityManagerInterface $em)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $provincia = $dataBase->getRepository(Provincias::class)->findBy(['code' => $request->get('provincia')]);
        $municipio = $dataBase->getRepository(Municipios::class)->findBy(['code' => $request->get('municipio')]);

        $json = array(
            'provincia' => $provincia[0]->getNombre(),
            'municipio' => $municipio[0]->getNombre(),
        );

        return new response(\json_encode($json));
    }

    /**
     * @Route("/remesas.carrito/{id}/{monto}/{recibir}/{idCliente}/{nombre}/{apellido}", name="remesas.carrito")
     */
    public function carrito($id, $monto, $recibir, $idCliente,$nombre,$apellido)
    {
        $dataBase = $this->getDoctrine()->getManager();
       // $carritoDataBase = $dataBase->getRepository(Carrito::class)->findBy([''=>'']);
 
        $carrito = new Carrito();
        $user =  $this->getUser();
        $ClienteBeneficiario = $dataBase->getRepository(ClienteBeneficiario::class)->find($id);
        $date = new DateTime('NOW');
        date_default_timezone_set('America/Santo_Domingo');

        $json = array(
            'id' => $ClienteBeneficiario->getId(),
            'primerNombre' => $ClienteBeneficiario->getPrimerNombre(),
            'primerApellido' => $ClienteBeneficiario->getPrimerApellido(),
            'segundoApellido' => $ClienteBeneficiario->getSegundoApellido(),
            'identificacion' => $ClienteBeneficiario->getIdentificacion(),
            'telefono' => $ClienteBeneficiario->getTelefono(),
            'telefonoCasa' => $ClienteBeneficiario->getTelefonoCasa(),
            'alternativoNombre' => $ClienteBeneficiario->getAlternativoNombre(),
            'alternativoApellido' => $ClienteBeneficiario->getAlternativoApellido(),
            'alternativoSegundoApellido' => $ClienteBeneficiario->getAlternativoSegundoApellido(),
            'calle' => $ClienteBeneficiario->getCalle(),
            'no' => $ClienteBeneficiario->getNo(),
            'entre' => $ClienteBeneficiario->getEntre(),
            'y' => $ClienteBeneficiario->getY(),
            'apto' => $ClienteBeneficiario->getApto(),
            'edificio' => $ClienteBeneficiario->getEdificio(),
            'reparto' => $ClienteBeneficiario->getReparto(),
            'provincia' => $ClienteBeneficiario->getProvincia(),
            'municipio' => $ClienteBeneficiario->getMunicipio(),
            'idCliente' => $ClienteBeneficiario->getIdCliente(),
            'nombreCliente' => $nombre.' '.$apellido,
            'remitenteNombre' => null,
            'remitenteApellido' => null,
            'comentario' => null,
            'fecha' => $date->format('Y-m-d H:i:s'),
            'empleado' => $user->getUsername(),
            'monto' => $monto,
            'recibir' => $recibir,
            'servicio' => 'Remesa',
            'orden' => uniqid()
        );

        $carrito->setEmpleado($user->getUsername());
        $carrito->setJson(json_encode($json));
        $dataBase->persist($carrito);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Remesa Agregada Al Carrito'
        );

        return $this->redirectToRoute('remesas.beneficiarios', ['tel' => $idCliente]);
    }

    /**
     * @Route("/remesas.json.editar/{id}", name="remesas.json.editar")
     */
    public function jsonEditar($id)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(Carrito::class)->find($id);

        $beneficiario = json_decode($data->getJson());

        return $this->render(
            'remesas/carrito-beneficiario.html.twig',
            ['beneficiario' => $beneficiario, 'id' => $id]
        );
    }

    /**
     * @Route("/remesas.json.editar.save/{id}", name="remesas.json.editar.save")
     */
    public function jsonSave($id, Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(Carrito::class)->find($id);

        $data->setJson($request->get('json'));
        $dataBase->flush();
        $this->addFlash(
            'success',
            'Editada'
        );

        return new response(200);
    }

    /**
     * @Route("/remesas.json.borrar/{id}", name="emesas.json.borrar")
     */
    public function jsonBorrar($id)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(Carrito::class)->find($id);

        $dataBase->remove($data);
        $dataBase->flush();

        return new response(200);
    }

    /**
     * @Route("/remesas/pais", name="remesas/pais")
     */
    public function pais()
    {
        //$dataBase = $this->getDoctrine()->getManager();
        //$data = $dataBase->getRepository(Pais::class)->findAll();

      
        return $this->render(
            'remesas/pais.html.twig'
        );
    }


    /**
     * @Route("/remesas/reglas/{id}", name="remesas/reglas")
     */
    public function reglas($id, EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $monedaPais = $dataBase->getRepository(MonedaPais::class)->find($id);
        $moneda = $dataBase->getRepository(Moneda::class)->find($monedaPais->getIdMoneda());
        $pais = $dataBase->getRepository(Pais::class)->find($monedaPais->getIdPais());

        $dql = "SELECT a FROM App:ReglasRemesas a WHERE  a.idMonedaPais = '$id' ";

        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
         25 /*limit per page*/
        );

        return $this->render('remesas/reglas.html.twig',['pais'=> $pais->getNombre(), 
        'moneda' => $moneda->getNombre(),'idReglas' => $id, 'pagination' => $pagination]);
    }

    /**
     * @Route("/remesas/reglas/add/{id}", name="remesas/reglas/add/")
     */
    public function reglasAdd($id, Request $request)
    {
        
        $dataBase = $this->getDoctrine()->getManager();
        $monedaPais = $dataBase->getRepository(MonedaPais::class)->find($id);
        $moneda = $dataBase->getRepository(Moneda::class)->find($monedaPais->getIdMoneda());
        $pais = $dataBase->getRepository(Pais::class)->find($monedaPais->getIdPais());

        $reglasRemesas = new ReglasRemesas();

        $formulario = $this->createForm(
            ReglasRemesasType::class,
             $reglasRemesas,
            array('action' => $this->generateUrl('remesas/reglas/add/', array('id' => $id)), 'method' => 'POST')
        );

        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $dataBase = $this->getDoctrine()->getManager();

            $reglasRemesas->setIdMonedaPais($id); 

            $dataBase->persist($reglasRemesas);
            $dataBase->flush();
          
            $this->addFlash(
                'success',
                'Regla Agregada'
            );

            return $this->redirectToRoute('remesas/reglas', ['id' => $id]);
        }

        return $this->render('remesas/reglasAdd.html.twig',['pais'=> $pais->getNombre(), 
        'moneda' => $moneda->getNombre(),'idReglas' => $id,  'formulario' => $formulario->createView()]);
    }

     /**
     * @Route("/remesas/reglas/edit/{id}/{idRegla}", name="remesas/reglas/edit/")
     */
    public function reglasEdit($id,$idRegla, Request $request)
    {
        
        $dataBase = $this->getDoctrine()->getManager();
        $monedaPais = $dataBase->getRepository(MonedaPais::class)->find($id);
        $moneda = $dataBase->getRepository(Moneda::class)->find($monedaPais->getIdMoneda());
        $pais = $dataBase->getRepository(Pais::class)->find($monedaPais->getIdPais());

        $reglasRemesas = $dataBase->getRepository(ReglasRemesas::class)->find($idRegla);

        $formulario = $this->createForm(
            ReglasRemesasType::class,
             $reglasRemesas,
            array('action' => $this->generateUrl('remesas/reglas/edit/', array('id' => $id,'idRegla' => $idRegla)), 'method' => 'POST')
        );

        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $dataBase = $this->getDoctrine()->getManager();

            $reglasRemesas->setIdMonedaPais($id); 

            //$dataBase->persist($reglasRemesas);
            $dataBase->flush($reglasRemesas);
          
            $this->addFlash(
                'success',
                'Regla Editada'
            );

            return $this->redirectToRoute('remesas/reglas', ['id' => $id]);
        }

        return $this->render('remesas/reglasAdd.html.twig',['pais'=> $pais->getNombre(), 
        'moneda' => $moneda->getNombre(),'idReglas' => $id,  'formulario' => $formulario->createView()]);
    }
}
