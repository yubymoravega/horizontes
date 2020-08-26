# Revisar siempre
- `ParanoidEntityRepository` hacer que los EntityRepositorys hereden de esta class que implementa el modo paranoid como en Nodejs
# TODO - Contabilidad
### Configuración
- [x] Crear las Entidades
- [x] CRUD por cada Entidad -- REVISION
    - [x] Config inicial 
    - [x] Almacén `u`
    - [x] Centro Costo --- `GUIA para validaciones` 
    - [x] Cuenta 
    - [x] Subcuenta
    - [ ] Elemento de Gasto
    - [ ] Grupo Activo ---camilo
    - [x] Instrumento Cobro `u`
    - [x] Modulo `u`
    - [x] Moneda `u`    
    - [ ] Tasa Cambio---camilo
    - [x] Tipo Documento `u`
    - [x] Tipo Documento Activo Fijo `u`
    - [x] Tipo Movimiento `u`
    - [ ] Unidad
    - [x] Unidad Medida `u`
- [ ] Refactorización el CODIGO   
   - [ ] Ajustar controladores `php bin/console make:crud` del ejemplo TestCrd
   , Las Rutas definir el método que esperan  como en `AlmacenCOntroller.php`
   - [ ] `php bin/console debug:Route` -> Revisar los métodos q acceden a las controladoras ("GET","POST") "DELETE"
   - [ ] validar formulario en el frontend o Jquery 
   - [ ] hacer q al borrar el formulario se limpie la opción de 
validar si esta requerido y al escribir también, ponerle un id al
`input`
- [ ]  paginación instalando el modulo de paginación
- [ ]  `AuxFunctions::existWidthFK()` -> para validar las llaves foraneas antes de eliminar
# Pendiente

### Investigar

### bugs
- cuando se actualiza el navegador con f5/click en el simbolo de actulizar
no se limpia el request anterior y se envia el mismo nuevamente
- los inputs no tienen un funcionamiento correcto, no permiten desplacamientos con las 
arrow ni seleccion mediante el teclado... algun problema con las librerias incorporadas al parecer