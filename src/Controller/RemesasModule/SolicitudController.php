<?php

namespace App\Controller\RemesasModule;

use App\CoreContabilidad\AuxFunctions;
use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Carrito;
use App\Entity\Cliente;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\Servicios;
use App\Entity\Contabilidad\Config\TasaCambio;
use App\Entity\MonedaPais;
use App\Entity\Municipios;
use App\Entity\Pais;
use App\Entity\Provincias;
use App\Entity\RemesasModule\Configuracion\BeneficiariosClientes;
use App\Entity\TurismoModule\Utils\ConfigPrecioVentaServicio;
use App\Entity\TurismoModule\Utils\UserClientTmp;
use App\Form\RemesasModule\Configuracion\BeneficiariosClientesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SolicitudController
 * @package App\Controller\RemesasModule
 * @Route("/servicios/remesas/solicitud")
 *
 */
class SolicitudController extends AbstractController
{
    /**
     * @Route("/", name="remesas_module_solicitud")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        /** @var Cliente $obj_cliente */
        $obj_cliente = AuxFunctionsTurismo::GetDataCliente($em, $this->getUser());
        $form = $this->createForm(BeneficiariosClientesType::class);

        $beneficiarios = $em->getRepository(BeneficiariosClientes::class)->findBy([
            'activo' => true,
            'id_cliente' => $obj_cliente
        ]);
        $data_beneficiarios = [];
        $beneficiario = [];
        foreach ($beneficiarios as $key => $item) {
            $beneficiario[] = [
                'index' => $key + 1,
                'nombre' => $item->getPrimerNombre(),
            ];
            $data_beneficiarios[] = [
                'index' => $key,
                'id_cliente' => $item->getIdCliente()->getId(),
                'primer_nombre' => $item->getPrimerNombre() ? $item->getPrimerNombre() : '',
                'primer_apellido' => $item->getPrimerApellido() ? $item->getPrimerApellido() : '',
                'segundo_apellido' => $item->getSegundoApellido() ? $item->getSegundoApellido() : '',
                'nombre_alternativo' => $item->getNombreAlternativo() ? $item->getNombreAlternativo() : '',
                'primer_apellido_alternativo' => $item->getPrimerApellidoAlternativo() ? $item->getPrimerApellidoAlternativo() : '',
                'segundo_apellido_alternativo' => $item->getSegundoApellidoAlternativo() ? $item->getSegundoApellidoAlternativo() : '',
                'primer_telefono' => $item->getPrimerTelefono() ? $item->getPrimerTelefono() : '',
                'segundo_telefono' => $item->getSegundoTelefono() ? $item->getSegundoTelefono() : '',
                'identificacion' => $item->getIdentificacion() ? $item->getIdentificacion() : '',
                'calle' => $item->getCalle() ? $item->getCalle() : '',
                'entre' => $item->getEntre() ? $item->getEntre() : '',
                'y' => $item->getY() ? $item->getY() : '',
                'nro_casa' => $item->getNroCasa() ? $item->getNroCasa() : '',
                'edificio' => $item->getEdificio() ? $item->getEdificio() : '',
                'apto' => $item->getApto() ? $item->getApto() : '',
                'reparto' => $item->getReparto() ? $item->getReparto() : '',
                'id_pais' => $item->getIdPais()->getId() ? $item->getIdPais()->getId() : '',
                'nombre_pais' => $item->getIdPais()->getNombre() ? $item->getIdPais()->getNombre() : '',
                'id_provincia' => $item->getIdProvincia()->getId() ? $item->getIdProvincia()->getId() : '',
                'nombre_provincia' => $item->getIdProvincia()->getNombre() ? $item->getIdProvincia()->getNombre() : '',
                'id_municipio' => $item->getIdMunicipio()->getId() ? $item->getIdMunicipio()->getId() : '',
                'nombre_municipio' => $item->getIdMunicipio()->getNombre() ? $item->getIdMunicipio()->getNombre() : '',
            ];
        }
        return $this->render('remesas_module/solicitud/index.html.twig', [
            'controller_name' => 'SolicitudController',
            'formulario' => $form->createView(),
            'id_cliente' => $obj_cliente->getId(),
            'data_baneficiarios' => $data_beneficiarios,
            'beneficiarios' => $beneficiario,
            'telefono' => $obj_cliente->getTelefono()
        ]);
    }

    /**
     * @Route("/getMonedas", name="get_monedad_remesas")
     */
    public function getMonedas(EntityManagerInterface $em, Request $request)
    {
        $id_pais = $request->request->get('id_pais');
        $monedas = $em->getRepository(MonedaPais::class)->findBy([
            'idPais' => $id_pais,
            'status' => 1
        ]);
        $moneda_er = $em->getRepository(Moneda::class);
        $row = [];
        foreach ($monedas as $item) {
            $row[] = [
                'id_moneda_pais' => $item->getId(),
                'moneda' => $moneda_er->findOneBy(['id' => $item->getIdMoneda()])->getNombre()
            ];
        }

        $provincias_pais = $em->getRepository(Provincias::class)->findBy([
            'id_pais' => $id_pais
        ]);
        $municipio_er = $em->getRepository(Municipios::class);
        $provincias = [];
        foreach ($provincias_pais as $item) {
            $municipio = [];
            $data_municipios = $municipio_er->findBy(['code' => $item->getCode()]);
            foreach ($data_municipios as $element) {
                $municipio[] = [
                    'id' => $element->getId(),
                    'nombre' => $element->getNombre()
                ];
            }
            $provincias[] = [
                'id_provincia' => $item->getId(),
                'nombre' => $item->getNombre(),
                'municipios' => $municipio
            ];
        }

        return new JsonResponse(['success' => true, 'monedas' => $row, 'provincias' => $provincias]);
    }

    /**
     * @Route("/getMontoPagar", name="getMontoPagar")
     */
    public function getMontoPagar(EntityManagerInterface $em, Request $request)
    {
        $cantidad = floatval($request->request->get('monto'));
        $id_moneda_pais = $request->request->get('id_moneda_pais');
        $id_pais = $request->request->get('id_pais');
        $id_moneda_select = $request->request->get('currency');
        $moneda_pais = $em->getRepository(MonedaPais::class)->find($id_moneda_pais);
        $tasa_cambio_er = $em->getRepository(TasaCambio::class);
        $moneda_er = $em->getRepository(Moneda::class);
        $moneda_usd = $moneda_er->findOneBy(['nombre' => 'usd', 'activo' => true]);
        $year = Date('Y');
        $month = Date('m');
        $tasa_cambio = $tasa_cambio_er->findOneBy([
            'anno' => $year,
            'mes' => $month,
            'activo' => true,
            'id_moneda_origen' => $moneda_er->find($moneda_pais->getIdMoneda()),
            'id_moneda_destino' => $moneda_usd
        ]);
        if ($moneda_er->find($moneda_pais->getIdMoneda()) == $moneda_usd)
            $monto_usd = $cantidad;
        else
            $monto_usd = $tasa_cambio->getValor() * $cantidad;

        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $data = AuxFunctionsTurismo::getDataRemesaPagar($em, $id_pais, $monto_usd, $unidad);
        $costo_venta=!empty($data)?floatval($data['costo']):0;
        $id_regla = !empty($data)?floatval($data['id_regla']):'';

        if ($costo_venta == 0)
            return new JsonResponse([
                'success' => true,
                'a_pagar' => round($costo_venta, 2)
            ]);

        $precio_venta = floatval($costo_venta);

        if ($id_moneda_select == $moneda_usd->getId())
            return new JsonResponse([
                'success' => true,
                'a_pagar' => round($precio_venta, 2),
                'id_regla'=>$id_regla
            ]);

        $tasa_cambio = $tasa_cambio_er->findOneBy([
            'anno' => $year,
            'mes' => $month,
            'activo' => true,
            'id_moneda_origen' => $moneda_usd,
            'id_moneda_destino' => $moneda_er->find($id_moneda_select)
        ]);
        $monto_moneda_select = $tasa_cambio->getValor() * $precio_venta;

        return new JsonResponse([
            'success' => true,
            'a_pagar' => round($monto_moneda_select, 2),
            'id_regla'=>$id_regla
        ]);
    }

    /**
     * @Route("/getMontoRecibir", name="getMontoRecibir")
     */
    public function getMontoRecibir(EntityManagerInterface $em, Request $request)
    {
        $cantidad = floatval($request->request->get('monto'));
        $id_moneda_pais = $request->request->get('id_moneda_pais');
        $id_pais = $request->request->get('id_pais');
        $id_moneda_select = $request->request->get('currency');
        $moneda_pais = $em->getRepository(MonedaPais::class)->find($id_moneda_pais);
        $tasa_cambio_er = $em->getRepository(TasaCambio::class);
        $moneda_er = $em->getRepository(Moneda::class);
        $moneda_usd = $moneda_er->findOneBy(['nombre' => 'usd', 'activo' => true]);
        $year = Date('Y');
        $month = Date('m');
        $tasa_cambio = $tasa_cambio_er->findOneBy([
            'anno' => $year,
            'mes' => $month,
            'activo' => true,
            'id_moneda_origen' => $moneda_er->find($id_moneda_select),
            'id_moneda_destino' => $moneda_usd
        ]);
        if ($moneda_er->find($id_moneda_select) == $moneda_usd)
            $monto_usd = $cantidad;
        else
            $monto_usd = $tasa_cambio->getValor() * $cantidad;

        $unidad = AuxFunctions::getUnidad($em, $this->getUser());

        $data = AuxFunctionsTurismo::getDataRemesaRecibir($em, $id_pais, $monto_usd, $unidad);
        $costo_venta=!empty($data)?floatval($data['costo']):0;
        $id_regla = !empty($data)?floatval($data['id_regla']):'';


        if ($costo_venta == 0)
            return new JsonResponse([
                'success' => true,
                'a_recibir' => round($costo_venta, 2)
            ]);
        $precio_venta = floatval($costo_venta);

        if ($moneda_pais->getIdMoneda() == $moneda_usd->getId())
            return new JsonResponse([
                'success' => true,
                'a_recibir' => round($precio_venta, 2),
                'id_regla'=>$id_regla
            ]);

        $tasa_cambio = $tasa_cambio_er->findOneBy([
            'anno' => $year,
            'mes' => $month,
            'activo' => true,
            'id_moneda_origen' => $moneda_usd,
            'id_moneda_destino' => $moneda_er->find($moneda_pais->getIdMoneda())
        ]);
        $monto_moneda_select = $tasa_cambio->getValor() * $precio_venta;

        return new JsonResponse([
            'success' => true,
            'a_recibir' => round($monto_moneda_select, 2),
            'id_regla'=>$id_regla
        ]);
    }

    /**
     * @Route("/saveBeneficiario", name="saveBeneficiario")
     */
    public function saveBeneficiario(EntityManagerInterface $em, Request $request)
    {
        $id_benaficiario_ = $request->request->get('id_banaficiario_');
        $nombre_ = $request->request->get('nombre_');
        $id_pais_ = $request->request->get('id_pais_');
        $id_provincia_ = $request->request->get('id_provincia_');
        $id_municipio_ = $request->request->get('id_municipio_');
        $primer_apellido_ = $request->request->get('primer_apellido_');
        $segundo_apellido_ = $request->request->get('segundo_apellido_');
        $nombre_alternativo_ = $request->request->get('nombre_alternativo_');
        $primer_apellido_alternativo_ = $request->request->get('primer_apellido_alternativo_');
        $segundo_apellido_alternativo_ = $request->request->get('segundo_apellido_alternativo_');
        $primer_telefono_ = $request->request->get('primer_telefono_');
        $segundo_telefono_ = $request->request->get('segundo_telefono_');
        $identificacion_ = $request->request->get('identificacion_');
        $calle_ = $request->request->get('calle_');
        $entre_ = $request->request->get('entre_');
        $y_ = $request->request->get('y_');
        $nro_casa_ = $request->request->get('nro_casa_');
        $edificio_ = $request->request->get('edificio_');
        $apto_ = $request->request->get('apto_');
        $reparto_ = $request->request->get('reparto_');

        $obj_cliente = AuxFunctionsTurismo::GetDataCliente($em, $this->getUser());

        if (!$id_benaficiario_ || $id_benaficiario_ == '') {
            $beneficiario = new BeneficiariosClientes();
        } else {
            $beneficiario = $em->getRepository(BeneficiariosClientes::class)->find($id_benaficiario_);
        }
        $beneficiario
            ->setActivo(true)
            ->setIdCliente($obj_cliente)
            ->setCalle($calle_)
            ->setEntre($entre_)
            ->setY($y_)
            ->setNroCasa($nro_casa_)
            ->setEdificio($edificio_)
            ->setApto($apto_)
            ->setReparto($reparto_)
            ->setIdPais($em->getRepository(Pais::class)->find($id_pais_))
            ->setIdProvincia($em->getRepository(Provincias::class)->find($id_provincia_))
            ->setIdMunicipio($em->getRepository(Municipios::class)->find($id_municipio_))
            ->setPrimerNombre($nombre_)
            ->setPrimerApellido($primer_apellido_)
            ->setSegundoApellido($segundo_apellido_)
            ->setNombreAlternativo($nombre_alternativo_)
            ->setPrimerApellidoAlternativo($primer_apellido_alternativo_)
            ->setSegundoApellidoAlternativo($segundo_apellido_alternativo_)
            ->setPrimerTelefono($primer_telefono_)
            ->setSegundoTelefono($segundo_telefono_)
            ->setIdentificacion($identificacion_);

        $em->persist($beneficiario);
        $em->flush();


        $beneficiarios = $em->getRepository(BeneficiariosClientes::class)->findBy([
            'activo' => true,
            'id_cliente' => $obj_cliente
        ]);
        $data_beneficiarios = [];
        $beneficiario = [];
        foreach ($beneficiarios as $key => $item) {
            $beneficiario[] = [
                'index' => $key + 1,
                'nombre' => $item->getPrimerNombre(),
            ];
            $data_beneficiarios[] = [
                'index' => $key,
                'id_cliente' => $item->getIdCliente()->getId(),
                'primer_nombre' => $item->getPrimerNombre() ? $item->getPrimerNombre() : '',
                'primer_apellido' => $item->getPrimerApellido() ? $item->getPrimerApellido() : '',
                'segundo_apellido' => $item->getSegundoApellido() ? $item->getSegundoApellido() : '',
                'nombre_alternativo' => $item->getNombreAlternativo() ? $item->getNombreAlternativo() : '',
                'primer_apellido_alternativo' => $item->getPrimerApellidoAlternativo() ? $item->getPrimerApellidoAlternativo() : '',
                'segundo_apellido_alternativo' => $item->getSegundoApellidoAlternativo() ? $item->getSegundoApellidoAlternativo() : '',
                'primer_telefono' => $item->getPrimerTelefono() ? $item->getPrimerTelefono() : '',
                'segundo_telefono' => $item->getSegundoTelefono() ? $item->getSegundoTelefono() : '',
                'identificacion' => $item->getIdentificacion() ? $item->getIdentificacion() : '',
                'calle' => $item->getCalle() ? $item->getCalle() : '',
                'entre' => $item->getEntre() ? $item->getEntre() : '',
                'y' => $item->getY() ? $item->getY() : '',
                'nro_casa' => $item->getNroCasa() ? $item->getNroCasa() : '',
                'edificio' => $item->getEdificio() ? $item->getEdificio() : '',
                'apto' => $item->getApto() ? $item->getApto() : '',
                'reparto' => $item->getReparto() ? $item->getReparto() : '',
                'id_pais' => $item->getIdPais()->getId() ? $item->getIdPais()->getId() : '',
                'nombre_pais' => $item->getIdPais()->getNombre() ? $item->getIdPais()->getNombre() : '',
                'id_provincia' => $item->getIdProvincia()->getId() ? $item->getIdProvincia()->getId() : '',
                'nombre_provincia' => $item->getIdProvincia()->getNombre() ? $item->getIdProvincia()->getNombre() : '',
                'id_municipio' => $item->getIdMunicipio()->getId() ? $item->getIdMunicipio()->getId() : '',
                'nombre_municipio' => $item->getIdMunicipio()->getNombre() ? $item->getIdMunicipio()->getNombre() : '',
            ];
        }
        return new JsonResponse([
                'success' => true,
                'data_baneficiarios' => $data_beneficiarios,
                'beneficiarios' => $beneficiario]
        );
    }

    /**
     * @Route("/add-carrito", name="add_carrito_remesa")
     */
    public function addCarrito(EntityManagerInterface $em, Request $request)
    {
        $id_servicio = AuxFunctionsTurismo::IDENTIFICADOR_REMESA;
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $moneda = $request->request->get('moneda');

        /** @var UserClientTmp $obj_trabajo_tmp */
        $obj_trabajo_tmp = $em->getRepository(UserClientTmp::class)->findOneBy([
            'id_usuario' => $this->getUser()
        ]);

        $empleado = $obj_trabajo_tmp->getIdUsuario()->getUsername();

        $configuraciones = $em->getRepository(ConfigPrecioVentaServicio::class)->findOneBy([
            'id_unidad' => $unidad,
            'identificador_servicio' => $id_servicio
        ]);

        $data_new_solicitudes = json_decode($request->request->get('solicitudes'), true);
        $data_solicitudes_existente = AuxFunctionsTurismo::getDataJsonCarrito($em, $empleado, $id_servicio);

        $data_solicitudes = array_merge($data_new_solicitudes, $data_solicitudes_existente);
        $precio_total = 0;
        foreach ($data_solicitudes as $key=>$item){
            if(gettype($data_solicitudes[$key])=='array'){
                $data_solicitudes[$key]['idCarrito'] = $key;
                $data_solicitudes[$key]['nombreMostrar'] = $data_solicitudes[$key]['nombre_'] .' '. $data_solicitudes[$key]['primer_apellido_'];
                $data_solicitudes[$key]['montoMostrar'] = $data_solicitudes[$key]['monto_entregar_'];
                $precio_total += floatval($data_solicitudes[$key]['monto_entregar_']);
            }
            else{
                $data_solicitudes[$key]->idCarrito = $key;
                $data_solicitudes[$key]->nombreMostrar = $data_solicitudes[$key]->nombre_ .' '. $data_solicitudes[$key]->primer_apellido_;
                $data_solicitudes[$key]->montoMostrar = $data_solicitudes[$key]->monto_entregar_;
                $precio_total += floatval($data_solicitudes[$key]->monto_entregar_);

            }
        }
        //-- CONSTRUYO EL JSON PARA ADICIONAR AL CARRITO
        $json = array(
            'id_empleado' => $obj_trabajo_tmp->getIdUsuario()->getId(),
            'id_cliente' => $obj_trabajo_tmp->getIdCliente()->getId(),
            'id_servicio' => $id_servicio,
            'id_moneda' => $moneda,
            'nombre_servicio' => $em->getRepository(Servicios::class)->find($id_servicio)->getNombre(),
            'precio_servicio' => $precio_total,
            'total' => $precio_total,
            'data' => $data_solicitudes,
        );


        if (!empty($data_solicitudes_existente)) {
            $new_element_carrito = $em->getRepository(Carrito::class)->find(AuxFunctionsTurismo::getIdCarritoServicio($em, $empleado, $id_servicio));
        } else {
            $new_element_carrito = new Carrito();
        }
        $new_element_carrito
            ->setEmpleado($empleado)
            ->setJson($json);

        $em->persist($new_element_carrito);
        $em->flush();

        $this->addFlash('success', 'Solicitud adicionada al carrito');

        return  $this->redirectToRoute('categorias',['tel'=>$obj_trabajo_tmp->getIdCliente()->getTelefono()] );
    }

}