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
    
    - Si Alguna de las Salidas es `eliminada` reestablecer la cantidad de Mercancia Restante ????
    - Unidad avilitar el combo para deselccionar la unidad subordinada
    - Nro. - para las ENtradas y salidas validar que no se puedan contabilizar las Elimnadas

### Inventario
- [ ] { Tipo Documento, Modulos } -> resolver el tema de los valores estaticos con un JSON, YAML u otro tipo de config
- [x] eliminar flechas de number o regex-> para esto
- [ ] validar el formato codigo cuenta
- [ ] poput para config inicial cuantas/subucenta/contraparti/etc.
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


####Tareas del dia de hoy(12/10/2020)
- [x] Quitar la seleccion de elemento de gasto y centro de costo en las trasnfereancias y vales de salida(leandro arreglar visual del btn y revisar la tabla de imprimir "total")
- [x] traer las abrebiaturas de las unidades de medida en los documentos
- [x] quitar los documentos cancelados en el submayor de inventario por producto
- [x] revisar por que no vienen las trasnferencias en el submayor de inventario por producto
- [x] en el listado de existencia por almacen traer por cuentas(ya lo hace) y subcuentas(hay que implementarlo)

- [x] revisar en todos los docuemtnos de entrada y salida que adicione el id_tipo_documento y el 
        anno en la tabla documento
- [x] Forzar al .00 en los listados de productos y mercancias
- [x] hacer un imprimir en los documentos tanto entrada como slaida que imprima el que se 
        esta elaborando, si necesidad de guardar e ir atras
        (ajuste, ajuste_salida)
- [ ] revisar a la hora de dar un consecutivo, si el ultimo esta cancelado, 
        reasignarlo ( cambia la logica de los consecutivos, en ves de contar 
        solo preguntaremos por el ultimo )
- [x] en los doc entrada y salida - add movimiento_mercancia o producto (id_almacen)