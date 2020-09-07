# Revisar siempre
- `ParanoidEntityRepository` hacer que los EntityRepositorys hereden de esta class que implementa el modo paranoid como en Nodejs
# TODO - Contabilidad
### Configuración
- [x] Crear las Entidades
- [x] CRUD por cada Entidad -- REVISION
    - [x] Config inicial 
    - [x] Almacén `u` 
        - [x] ponerle la Unidad
    - [x] Centro Costo --->>> `GUIA DE CODIFICACION` 
    - [x] Cuenta 
    - [x] Subcuenta
    - [x] Elemento de Gasto 
    - [x] Grupo Activo ---camilo
    - [x] Instrumento Cobro `u`
    - [x] Modulo `u`
    - [x] Moneda `u`    
    - [x] Tasa Cambio---camilo
    - [x] Tipo Documento `u`
    - [x] Tipo Documento Activo Fijo `u`
    - [x] Tipo Movimiento `u`
    - [x] Unidad
    - [x] Unidad Medida `u`

### Inventario
- [ ] { Tipo Documento, Modulos } -> resolver el tema de los valores estaticos con un JSON, YAML u otro tipo de config
- eliminar flechas de number o regex-> para esto
- LOADING...
    - [ ] http://127.0.0.1:8000/contabilidad/config/conf-inicial/form-add
- [ ] validar el formato codigo cuenta
       
# Pendiente
- [ ]  `AuxFunctions::existWidthFK()` -> para validar las llaves foraneas antes de eliminar

### Investigar
- Como poner la variable de Id almacen seleccionado en session o como sea para usarlo en el modulo de inventario.(OJO)

### bugs
- los inputs no tienen un funcionamiento correcto, no permiten desplacamientos con las 
arrow ni seleccion mediante el teclado... algun problema con las librerias incorporadas al parecer

###Pendiente a revisar e implementar(Camilo)
- En Informe de recepción:
    - El isValid() del formulario no se esta enviando
    - en obligacion de pago porner la entiguedad por periodo(<30 dias, entre 30-60 dias, entre 60-90 y >90 dias)
    - en mercancia tengo que hacer una tarjeta de estiva()
    - en todas las tablase de base de dato de inventario tengo que cambiar donde guardo precio, guardar importe(OJO)
    
#####El cierre diario es por cuentas dentro del almacen
saldo anterior(cierre del dia anterior) + debitos(cuentas de inventaro) - credito(vales de salida, tranferencias de salida y ajuste de salida) = saldo actual(tiene que ser igual a la suma de todos los importes de ls productos que pertenecen a las cuentas  relacionadas)
la suma de los saldos de las cuentas tiene que ser igual a la suma de los importes de los productos que pertenecen a cada cuenta

OJO NUEVO
verifica rque el producto tiene que estar asociado por cuentas(1 producto solo puede estar asociado a una sola cuenta), si trata de adicionar el mismo codigo de mercancia en diferente cuenta enviar alerta y no permitirlo
