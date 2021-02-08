<?php

namespace App\Controller;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Servicios;
use App\Entity\Contabilidad\Inventario\AlmacenOcupado;
use App\Entity\User;
use App\Entity\Carrito;
use App\Entity\Pais;
use App\Entity\MonedaPais;
use App\Entity\TasaDeCambio;
use App\Form\Contabilidad\Config\MonedaType;
use App\Entity\Contabilidad\Config\Moneda;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuild;
use Doctrine\ORM\Query;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\SolicitudTurismo;

class HomeController extends AbstractController
{

      // 2. Expose the EntityManager in the class level
      private $entityManager;

      public function __construct(EntityManagerInterface $entityManager,HttpClientInterface $client)
     {
         // 3. Update the value of the private entityManager variable through injection
         $this->entityManager = $entityManager;
         $this->client = $client;
     }
 

    /**
     * @Route("/home", name="home")
     */
    public function home()
    {
        //Código del módulo de CONTABILIDAD, NO BORRAR
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $almacen_ocupado_er = $em->getRepository(AlmacenOcupado::class);
        $obj_almacen_ocupado = $almacen_ocupado_er->findOneBy(array(
            'id_usuario' => $user
        ));
        if ($obj_almacen_ocupado) {
            $em->remove($obj_almacen_ocupado);
            $em->flush();
        }
        //Fin del código

        $user->getRoles();

        return $this->render('home/index.html.twig');
    }

     /**
     * @Route("/categorias/{tel}", name="categorias")
     */
    public function categorias($tel)
    {
        $user =  $this->getUser();
//        if($user->getRoles()['rol'] == "ROLE_5918"){
//            return $this->redirectToRoute('turismo/solicitud',['cliente' => $tel]);
//        }

        return $this->render('home/categoria.html.twig',['tel' => $tel]);
    } 

     /**
     * @Route("/categorias/turismo/{tel}", name="categorias/turismo")
     */
    public function categoriasTurismo($tel)
    {
        return $this->render('home/categoriaTurismo.html.twig',['tel' => $tel]);
    } 

    /**
     * @Route("/servicios", name="servicios")
     */
    public function servicios()
    {
        return $this->render('home/servicios.html.twig');
    }

    /**
     * @Route("/carrito", name="carrito")
     */
    public function carrito(EntityManagerInterface $em)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $user =  $this->getUser();
        
        $data = $dataBase->getRepository(Carrito::class)->findBY(['empleado' => $user->getUsername()]);
        $json = null;
        $con = count( $data);
        $contador = 0;
        $decode = null;

        $servicio_er = $em->getRepository(Servicios::class);

        while($contador < $con){
            /** @var Servicios $element_servicio */
            $decode = json_decode($data[$contador]->getJson());
            $element_servicio = $servicio_er->find($decode->id_servicio);
                $json[$contador] = array(
                    'servicio'=>$decode->id_servicio,
                    'id' => $data[$contador]->getId(),
                    'json' => $data[$contador]->getJson(),
                    'moneda' => 'USD',
                    'total' => number_format($decode->total, 2,),
                    'servicio_nombre'=>$element_servicio?$element_servicio->getNombre():'-sin definir servicio-'
                );
            $contador++;
        }
 
        return new Response(json_encode($json));
    } 

    /**
     * @Route("/home/moneda", name="home/moneda")
     */
    public function moneda(Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        if ($request->get('moneda')) {

            $data = $dataBase->getRepository(User::class)->find($user->getId());

            $data->setIdMoneda($request->get('moneda'));

            $dataBase->flush($data);

            $this->addFlash(
                'success',
                'Moneda Seleccionada'
            );

            return $this->redirectToRoute('home');

        }

        $data = $dataBase->getRepository(Moneda::class)->findAll(false);

        return $this->render('home/moneda.html.twig', ['moneda' => $data, 'userMonedaId' => $user->getIdMoneda()]);

    }


    /**
     * @Route("/home/moneda/menu", name="home/moneda/menu")
     */
    public function monedaMenu(Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $data = $dataBase->getRepository(Moneda::class)->findAll(false);

        $array = null;
        $con = count($data);
        $contador = 0;


        while ($contador < $con) {

            if ($data[$contador]->getId() == $user->getIdMoneda()) {

                //return new response ($data[$contador]->getNombre());
                $array[$contador] = array('code' => $data[$contador]->getId(),
                    'nombre' => $data[$contador]->getNombre(), 'estatus' => 'selected');

            } else {

                $array[$contador] = array('code' => $data[$contador]->getId(),
                    'nombre' => $data[$contador]->getNombre());
            }

            $contador++;
        }


        return new response (\json_encode($array));

    }

    /**
     * @Route("/home/pais", name="home/pais")
     */
    public function pais(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();

        $paises = $this->getDoctrine()->getRepository(pais::class)->findAll();
        $monedas = $this->getDoctrine()->getRepository(Moneda::class)->findAll(false);

        $titulo = 'Seleccionar Pais';
        if ($request->get('pais')) {

            $titulo = $this->getDoctrine()->getRepository(pais::class)->find($request->get('pais'))->getNombre();
            $codePais = $this->getDoctrine()->getRepository(pais::class)->find($request->get('pais'))->getId();
        }

        $pais = 0;
        ($request->get('pais')) ? $pais = $request->get('pais') : $pais = 0;

        $dql = "SELECT a.id,b FROM App:MonedaPais a JOIN App:Contabilidad\Config\Moneda b WHERE  a.idPais = '$pais' AND  a.idMoneda = b.id AND  a.status ='1'";

        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        return $this->render(
            'home/pais.html.twig',
            ['paises' => $paises, 'titulo' => $titulo, 'monedas' => $monedas, 'pagination' => $pagination]
        );

    }

    /**
     * @Route("/home/moneda/pais/{moneda}/{pais}", name="home/moneda/pais")
     */
    public function saveMonedaPais($moneda, $pais, Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();

        $Moneda = $dataBase->getRepository(MonedaPais::class)->findBy(['idPais' => $pais, 'idMoneda' => $moneda, 'status' => true]);

        if ($Moneda) {

            $this->addFlash(
                'success',
                'Esta Moneda Ya Esta Agregada'
            );

        } else {

            $Moneda = $dataBase->getRepository(MonedaPais::class)->findBy(['idPais' => $pais, 'idMoneda' => $moneda, 'status' => false]);

            if ($Moneda) {

                $moneda->setStatus(true);
                $dataBase->flush($moneda);

                $this->addFlash(
                    'success',
                    'Moneda Agregada'
                );

            } else {

                $monedaPais = new MonedaPais();
                $monedaPais->setIdMoneda($moneda);
                $monedaPais->setIdPais($pais);
                $monedaPais->setStatus(1);
                $dataBase->persist($monedaPais);
                $dataBase->flush();

            }

            $this->addFlash(
                'success',
                'Moneda Agregada'
            );

        }

        return new response (200);

    }

    /**
     * @Route("/home/moneda/delete/{id}", name="home/moneda/delete")
     */
    public function eliminarMoneda($id, Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $moneda = $dataBase->getRepository(MonedaPais::class)->find($id);
        $moneda->setStatus(0);
        $dataBase->flush($moneda);

        $this->addFlash(
            'success',
            'Moneda Eliminada'
        );

        return new response (200);

    }

    /**
     * @Route("/home/moneda/tasa/", name="home/moneda/tasa")
     */
    public function tasa(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();

        $dql = "SELECT a,b.nombre FROM App:TasaDeCambio a JOIN App:Contabilidad\Config\Moneda b WHERE  a.idMoneda = b.id ";

        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        return $this->render('home/tasa.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/home/moneda/tasa/edit/{id}/{tasa}", name="home/moneda/tasa/edit")
     */
    public function tasaEdit($id, $tasa, Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();
        $data = $dataBase->getRepository(TasaDeCambio::class)->find($id);
        $data->setTasa($tasa);
        $dataBase->flush($data);

        $this->addFlash(
            'success',
            'Tasa modificada'
        );

        return new response (200);

    }

    /**
     * @Route("/home/moneda/tasa/sugerida/", name="home/moneda/tasa/sugerida")
     */
    public function tasaSugerida(Request $request) 
    {
        $dataBase = $this->getDoctrine()->getManager();
        $moneda = $dataBase->getRepository(Moneda::class)->findall();


        $con = count($moneda);
        $contador = 0;

        while ($contador < $con) {

            $tasaDeCambio = $dataBase->getRepository(TasaDeCambio::class)->findBy(['idMoneda' => $moneda[$contador]->getId()]);

            if ($tasaDeCambio) {
                $data = $this->client->request('GET', "https://free.currconv.com/api/v7/convert?q=USD_" . $moneda[$contador]->getNombre() . "&compact=ultra&apiKey=a4421db2eb9acbda611e");

                if ($data->getStatusCode() == 200) {
                    $array = $data->toArray();
                    $tasaDeCambio[0]->setTasaSugerida($array["USD_" . $moneda[$contador]->getNombre()]);

                    $dataBase->flush($tasaDeCambio);
                }

            } else {

                $data = $this->client->request('GET', "https://free.currconv.com/api/v7/convert?q=USD_" . $moneda[$contador]->getNombre() . "&compact=ultra&apiKey=a4421db2eb9acbda611e");

                if ($data->getStatusCode() == 200) {

                    $array = $data->toArray();
                    $tasaDeCambio = new  TasaDeCambio();
                    $tasaDeCambio->setTasa(0);
                    $tasaDeCambio->setIdMoneda($moneda[$contador]->getId());
                    $tasaDeCambio->setTasaSugerida($array["USD_" . $moneda[$contador]->getNombre()]);
                    $dataBase->persist($tasaDeCambio);
                    $dataBase->flush();
                }
            }

            $contador++;
        }

        return new response (200);

    }

    /**
     * @Route("/home/moneda/select/{code}", name="home/moneda/select/")
     */
    public function monedaMenuSelect($code, Request $request)
    {
        $dataBase = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        if ($code) {

            $data = $dataBase->getRepository(User::class)->find($user->getId());

            $data->setIdMoneda($code);

            $dataBase->flush($data);

            $this->addFlash(
                'success',
                'Moneda Seleccionada'
            );

        }
        return new response (200);

    }

    /**
     * @Route("/home/atender/", name="home/atender/")
     */
    public function atenderNotificaciones()
    {
        $dataBase = $this->getDoctrine()->getManager();
        // $user =  $this->getUser();
        $data = $dataBase->getRepository(SolicitudTurismo::class)->findBy(["stado" => "Pendiente"]);

        $contador = count($data);

        return new response ($contador);

    }

}
