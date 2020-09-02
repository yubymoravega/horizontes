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
