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
use App\Entity\TasaDeCambio;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\ClienteBeneficiario;
use App\Form\ClienteBeneficiarioType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Contabilidad\Config\Servicios;


class RemesasController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $client)
    {
        // 3. Update the value of the private entityManager variable through injection
        $this->entityManager = $entityManager;
        $this->client = $client;
    }

    /**
     * @Route("/remesas.add/{tel}/{pais}", name="remesas.add")
     */
    public function add($tel,$pais, Request $request)
    {
        $ClienteBeneficiario = new ClienteBeneficiario();

        $dataBase = $this->getDoctrine()->getManager();

        $provincias = $dataBase->getRepository(Provincias::class)->findAll();
        $municipios = $dataBase->getRepository(Municipios::class)->findAll();

        $ClienteBeneficiario->setIdCliente($tel);

        $formulario = $this->createForm(
            ClienteBeneficiarioType::class,
            $ClienteBeneficiario,
            array('action' => $this->generateUrl('remesas.add', array('tel' => $tel,'pais' => $pais)), 'method' => 'POST')
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

            return $this->redirectToRoute('remesas.beneficiarios', ['tel' => $tel,'pais' => $pais]);
        } else {

            return $this->render('remesas/add-beneficiario.html.twig', [
                'formulario' => $formulario->createView(), 'provincias' => $provincias, 'municipios' => $municipios,
                'provinciaSelect' => false,
                'municipioSelect' => false
            ]);
        }
    }


     /**
     * @Route("/remesas.edit/{id}/{pais}", name="remesas.edit")
     */
    public function edit($id,$pais, Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $ClienteBeneficiario = $dataBase->getRepository(ClienteBeneficiario::class)->find($id);

        $provincias = $dataBase->getRepository(Provincias::class)->findAll();
        $municipios = $dataBase->getRepository(Municipios::class)->findAll();

        //$ClienteBeneficiario->setIdCliente($tel);

        $formulario = $this->createForm(
            ClienteBeneficiarioType::class,
            $ClienteBeneficiario,
            array('action' => $this->generateUrl('remesas.edit', array('id' => $ClienteBeneficiario->getId(),'pais' => $pais)), 'method' => 'POST')
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

            return $this->redirectToRoute('remesas.beneficiarios', ['tel' => $ClienteBeneficiario->getIdCliente(),'pais' => $pais]);
            } else {
               
            return $this->render('remesas/add-beneficiario.html.twig', [
                'formulario' => $formulario->createView(), 'provincias' => $provincias,
                'provinciaSelect' => $ClienteBeneficiario->getProvincia(),
                'municipioSelect' => $ClienteBeneficiario->getMunicipio()
            ]);
        }
    }

    /**
     * @Route("/remesas.beneficiarios/{tel}/{pais}", name="remesas.beneficiarios")
     */
    public function beneficiarios($tel, $pais, EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
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

        $monedaPais = $dataBase->getRepository(MonedaPais::class)->findBy(['idPais' => $pais, 'status' => '1']);
       
        $con = count($monedaPais);
        $contador = 0;
        $array = null;

        while ($contador < $con) {

            $nombreMoneda = $dataBase->getRepository(Moneda::class)->find($monedaPais[$contador]->getIdMoneda());

            $array[$contador] = array(
                'code' => $nombreMoneda->getId(),
                'nombre' => $nombreMoneda->getNombre()          
            );
            $contador++;
        }

        return $this->render(
            'remesas/beneficiarios.html.twig',
            ['pais' => $pais, 'monedaPais'=>$array, 'moneda' => $moneda, 'pagination' => $pagination, 'id' =>  $data[0]->getTelefono(), 'nombre' =>  $data[0]->getNombre(), 'apellido' => $data[0]->getApellidos()]
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
     * @Route("/remesas.carrito/{id}/{monto}/{recibir}/{idCliente}/{nombre}/{apellido}/{moneda}/{pais}", name="remesas.carrito")
     */
    public function carrito($id, $monto, $recibir, $idCliente,$nombre,$apellido,$moneda,$pais, EntityManagerInterface $em)
    {
        $dataBase = $this->getDoctrine()->getManager();
      
        $user =  $this->getUser();
        $ClienteBeneficiario = $dataBase->getRepository(ClienteBeneficiario::class)->find($id);
        date_default_timezone_set('America/Santo_Domingo');
        $date = new DateTime('NOW');

        $data_remesa_existente = AuxFunctionsTurismo::getDataJsonCarrito($em, $user->getUsername(), AuxFunctionsTurismo::IDENTIFICADOR_REMESA);
        
        $data_new_remesa[] = array(
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
            'provincia' => $dataBase->getRepository(Provincias::class)->findBy(['code' => $ClienteBeneficiario->getProvincia()])[0]->getNombre(),
            'municipio' => $dataBase->getRepository(Municipios::class)->findBy(['code' => $ClienteBeneficiario->getMunicipio()])[0]->getNombre(),
            'idCliente' => $ClienteBeneficiario->getIdCliente(),
            'nombreCliente' => $nombre.' '.$apellido,
            'remitenteNombre' => null,
            'remitenteApellido' => null,
            'comentario' => null,
            'fecha' => $date->format('Y-m-d H:i:s'),
            'empleado' => $user->getUsername(),
            'monto' => number_format($monto, 2),
            'montoMoneda' =>  $user->getIdMoneda(),
            'recibir' => $recibir,
            'recibirMoneda' => $moneda,
            'pais' => $pais,
            'servicio' => 'Remesa',
            'orden' => uniqid(),
            'idCarrito' => count($data_remesa_existente) +1,
            'nombreMostrar' => $ClienteBeneficiario->getPrimerNombre()." ".$ClienteBeneficiario->getPrimerApellido(),
            'montoMostrar' => $monto
        );

        $data_remesa = array_merge($data_new_remesa, $data_remesa_existente);

        $total = null;

        foreach($data_remesa as $key=>$item){
        
            if(gettype($data_remesa[$key]) == 'array'){

                $total =  $total + $data_remesa[$key]['monto'] ; 

            }else{
                $total =  $total + $data_remesa[$key]->monto; 
            }

        }

        //-- CONSTRUYO EL JSON PARA ADICIONAR AL CARRITO
        $json = array(
            'id_empleado' => $user->getId(),
            'id_cliente' => $idCliente,
            'id_servicio' => AuxFunctionsTurismo::IDENTIFICADOR_REMESA,
            'nombre_servicio' => $em->getRepository(Servicios::class)->find(AuxFunctionsTurismo::IDENTIFICADOR_REMESA)->getNombre(),
            'precio_servicio' => 0,
            'total' => $total,
            'data' => $data_remesa,
        );
       
        
        if (!empty($data_remesa_existente)) {
            $new_element_carrito = $em->getRepository(Carrito::class)->find(AuxFunctionsTurismo::getIdCarritoServicio($em, $user->getUsername(), AuxFunctionsTurismo::IDENTIFICADOR_REMESA));
           
            $new_element_carrito
            ->setEmpleado($user->getUsername())
            ->setJson(json_encode($json));

            $em->flush($new_element_carrito);
        
        } else {
            $new_element_carrito = new Carrito();
           
            $new_element_carrito
            ->setEmpleado($user->getUsername())
            ->setJson(json_encode($json));

            $em->persist($new_element_carrito);
            $em->flush();
        }
       

        $this->addFlash(
            'success',
            'Remesa Agregada Al Carrito'
        );

        return $this->redirectToRoute('remesas.beneficiarios', ['tel' => $idCliente,'pais' => $pais]);
    }

    /**
     * @Route("/remesas.json.editar/{id}", name="remesas.json.editar")
     */
    public function jsonEditar($id)
    {
        $user =  $this->getUser();
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(Carrito::class)->find($id);
        $moneda = $dataBase->getRepository(Moneda::class)->find($user->getIdMoneda());

        $beneficiario = json_decode($data->getJson());

        $monedaPais = $dataBase->getRepository(MonedaPais::class)->findBy(['idPais' =>$beneficiario->pais, 'status' => '1']);
       
        $con = count($monedaPais);
        $contador = 0;
        $array = null;

        $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=>$beneficiario->montoMoneda]);

        $dolares = $beneficiario->monto / $tasa[0]->getTasa();
        $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $user->getIdMoneda()]);
        $beneficiario->monto = $dolares * $tasa[0]->getTasa();

        while ($contador < $con) {

            $nombreMoneda = $dataBase->getRepository(Moneda::class)->find($monedaPais[$contador]->getIdMoneda());

            $array[$contador] = array(
                'code' => $nombreMoneda->getId(),
                'nombre' => $nombreMoneda->getNombre()          
            );
            $contador++;
        }

        return $this->render(
            'remesas/carrito-beneficiario.html.twig',
            ['monedaPais'=>$array,'moneda' => $moneda,'beneficiario' => $beneficiario, 'id' => $id]
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
     * @Route("/remesas/pais/{tel}", name="remesas/pais/")
     */
    public function pais($tel)
    {
        return $this->render(
            'remesas/pais.html.twig',['tel' => $tel]
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

            $reglasAll = $dataBase->getRepository(ReglasRemesas::class)->findBy(['idMonedaPais'=>$reglasRemesas->getIdMonedaPais()]);

            $con = count($reglasAll);
            $validacion = 0;
            $contador = 0;

            while ($contador < $con) {

                if($reglasRemesas->getDesde() > $reglasAll[$contador]->getDesde() & $reglasRemesas->getDesde() > $reglasAll[$contador]->getHasta()){

                    $validacion++;

                }else{

                    $this->addFlash(
                        'error',
                        'Una regla no puede chocar con la otra'
                    );
                    return $this->redirectToRoute('remesas/reglas', ['id' => $id]);

                }
            $contador++;}

            if($con == $validacion){

                $dataBase->persist($reglasRemesas);
                $dataBase->flush();
              
                $this->addFlash(
                    'success',
                    'Regla Agregada'
                );
            }

            

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

    /**
     * @Route("/remesas/tasaMoneda/{moneda}/{cantidad}/{pais}", name="/remesas/tasaMoneda/")
     */
    public function tasaMoneda($moneda,$cantidad,$pais)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $user =  $this->getUser();
        $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=>$moneda]);
        $total = null ;

        if($user->getIdMoneda() == 1){

            if($tasa[0]->getTasa() > 0){
                $total = $cantidad * $tasa[0]->getTasa();
            
            }else{
                $total = $cantidad * $tasa[0]->getTasaSugerida();
            }
            
            
        }else{

            $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $user->getIdMoneda()]);

            if($tasa[0]->getTasa() > 0){

                $total = $cantidad / $tasa[0]->getTasa();
                $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=>$moneda]);

                if($tasa[0]->getTasa() > 0){
                    $total = $total * $tasa[0]->getTasa();
               
                }else{
                    $total = $total * $tasa[0]->getTasaSugerida();
                }
            
            }else{
               
                $total = $cantidad / $tasa[0]->getTasaSugerida();
                $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=>$moneda]);

                if($tasa[0]->getTasa() > 0){
                    $total = $total * $tasa[0]->getTasa();
               
                }else{
                    $total = $total * $tasa[0]->getTasaSugerida();
                }
            }

        }

        $monedaPais = $dataBase->getRepository(MonedaPais::class)->findBy(['idMoneda'=>$moneda,'idPais'=>$pais,'status'=>'1']);
        $reglasRemesas = $dataBase->getRepository(ReglasRemesas::class)->findBy(['idMonedaPais' => $monedaPais]);

        $con = count($reglasRemesas);
        $contador = 0;

        $tasaUserMoneda = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=> $user->getIdMoneda()]);

        $dolarRegla = $cantidad / $tasaUserMoneda[0]->getTasa();

        while ($contador < $con) {

            if($dolarRegla >=  $reglasRemesas[$contador]->getDesde() & $dolarRegla <=  $reglasRemesas[$contador]->getHasta()){

                if($reglasRemesas[$contador]->getTarifa() == "porciento"){

                    $porciento = $total /100; $total = $total - ($porciento * $reglasRemesas[$contador]->getValor());
                
                }else{

                    $total = $total - ( $tasa[0]->getTasa() * $reglasRemesas[$contador]->getValor());
                }
            }
            $contador++;
        }

        return new Response(round( $total, 0, PHP_ROUND_HALF_DOWN));

       
    }


     /**
     * @Route("/remesas/tasaMoneda/recibir/{moneda}/{cantidad}/{pais}", name="/remesas/tasaMoneda/recibir/")
     */
    public function tasaMonedaReves($moneda,$cantidad,$pais)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $user =  $this->getUser();
        $tasa = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=>$moneda]);
        $total = null ;

        $monedaPais = $dataBase->getRepository(MonedaPais::class)->findBy(['idMoneda'=>$moneda,'idPais'=>$pais,'status'=>'1']);
        $reglasRemesas = $dataBase->getRepository(ReglasRemesas::class)->findBy(['idMonedaPais' => $monedaPais]);

        $con = count($reglasRemesas);
        $contador = 0;

        $dolarRegla = $cantidad / $tasa[0]->getTasa();

        while ($contador < $con) {

            if($dolarRegla >=  $reglasRemesas[$contador]->getDesde() & $dolarRegla <=  $reglasRemesas[$contador]->getHasta()){

                if($reglasRemesas[$contador]->getTarifa() == "porciento"){

                    $porciento =  $dolarRegla /100; 
                    $total =  $dolarRegla + ($porciento * $reglasRemesas[$contador]->getValor());
                
                }else{

                    $total =  $dolarRegla  + $reglasRemesas[$contador]->getValor();
                }
            }
            $contador++;
        }

       // $total = round($total, 0, PHP_ROUND_HALF_DOWN);
       
        $tasaUsuario = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda'=>$user->getIdMoneda()]);

        $monedaPagada = $tasaUsuario[0]->getTasa() * $total ;
        
        return new Response(round($monedaPagada, 0, PHP_ROUND_HALF_EVEN));
    }

     /**
     * @Route("/remesas/prueba/", name="remesas/prueba")
     */
    public function prueba()
    {
       /* $response = $this->client->request('POST', 'http://www.virtualrg.com/wsfamily/service1.asmx', [
            'json' => [
               'mCustomerID' => '4327861528',
                'mAPIKey' => 'rnl370fwi6',
              'mKeyValue' => 'abce123456',
              'mDenomination' => 'CUC',
              'mAmount' => '10.00',
              'mNote' => 'Remesa de prueba',
              'mSourceName' => 'Jose Miguel De Jesus',
              'mSourcePhoneNo' => '8095648845',
              'mTargetFirstName' => 'Adrian',
              'mTargetLastName' => 'Gonzales',
              'mTargetFirstName2' => '',
              'mTargetLastName2' => '',
              'mTargetAddress' => 'Calle esquina municipio',
              'mProvinceID' => '32',
              'mMunicipalityID' => '3204',
              'mTargetPhoneNo' => '53914814',
              'mTargetPhoneNo2' => '',
          
            ]
          ]);*/


         /* $response = $this->client->request('POST', 'http://www.virtualrg.com/wsfamily/service1.asmx', [
            'gh' => [    
              'mCustomerID' => '4327861528',
              'mAPIKey' => 'rnl370fwi6',
              'mOrderNo' => 'CF0000119984',           
            ]
          ]);

    $respuesta = $response->getStatusCode(); */

    $client = new \Soapclient('http://www.virtualrg.com/wsfamily/service1.asmx?WSDL',);

   $respuesta = $client->Family_Transaction([
  'mCustomerID' => '4327861528',
  'mAPIKey' => 'rnl370fwi6',
  'mKeyValue' => 'abce123458',
  'mDenomination' => 'CUC',
  'mAmount' => '10.00',
  'mNote' => 'Remesa de prueba',
  'mSourceName' => 'Jose Miguel De Jesus',
  'mSourcePhoneNo' => '8095648845',
  'mTargetFirstName' => 'Adrian',
  'mTargetLastName' => 'Gonzales',
  'mTargetFirstName2' => '',
  'mTargetLastName2' => '',
  'mTargetAddress' => 'Calle esquina municipio',
  'mProvinceID' => '32',
  'mMunicipalityID' => '3204',
  'mTargetPhoneNo' => '53914814',
  'mTargetPhoneNo2' => '',
        ]);
   

    return new Response($respuesta->mOrderNo);
   // return new Response("200"); CF0000120321
    }
}
