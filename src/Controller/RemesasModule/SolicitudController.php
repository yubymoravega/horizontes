<?php

namespace App\Controller\RemesasModule;

use App\CoreContabilidad\AuxFunctions;
use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Cliente;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\TasaCambio;
use App\Entity\MonedaPais;
use App\Entity\Municipios;
use App\Entity\Provincias;
use App\Entity\RemesasModule\Configuracion\BeneficiariosClientes;
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
        $costo_venta = AuxFunctionsTurismo::getDataRemesaPagar($em, $id_pais, $monto_usd, $unidad);

        $precio_venta = floatval($costo_venta);

        if ($id_moneda_select == $moneda_usd->getId())
            return new JsonResponse([
                'success' => true,
                'a_pagar' => round($precio_venta, 2)
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
            'a_pagar' => round($monto_moneda_select, 2)
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

        $costo_venta = AuxFunctionsTurismo::getDataRemesaRecibir($em, $id_pais, $monto_usd, $unidad);
//        dd($costo_venta);
        if ($costo_venta == 0)
            return new JsonResponse([
                'success' => true,
                'a_recibir' => round($costo_venta, 2)
            ]);
        $precio_venta = floatval($costo_venta);

        if ($moneda_pais->getIdMoneda() == $moneda_usd->getId())
            return new JsonResponse([
                'success' => true,
                'a_recibir' => round($precio_venta, 2)
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
            'a_recibir' => round($monto_moneda_select, 2)
        ]);
    }


}