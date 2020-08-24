# Revisar siempre
- `ParanoidEntityRepository` hacer que los EntityRepositorys hereden de esta clas que implementa el modo
paranoid como en Nodejs
# TODO - Contabilidad
### Configuración
- [x] Crear las Entidadesde
- [x] CRUD por cada Entidad -- REVISION
    - [x] Config inicial 
    - [x] Almacén `u`
    - [x] Centro Costo --- `GUIA para validaciones` 
    - [ ] Cuenta 
    - [ ] Elemento de Gasto
    - [ ] Grupo Activo ---camilo
    - [x] Instrumento Cobro `u`
    - [x] Modulo `u`
    - [x] Moneda `u`
    - [ ] Subcuenta
    - [ ] Tasa Cambio---camilo
    - [x] Tipo Documento `u`
    - [x] Tipo Documento Activo Fijo `u`
    - [x] Tipo Movimiento `u`
    - [ ] Unidad
    - [x] Unidad Medida `u`
- [ ] Refactorizacion el CODIGO   
   - [ ] Ajustar controladores `php bin/console make:crud` del ejemplo TestCrd
   , Las Rutas definir el metodo que esperan  como en `AlmacenCOntroller.php`
   - [ ] `php bin/console debug:Route` -> Revisar los metodos q acceden a las controladoras ("GET","POST") "DELETE"
   - [ ] validar formulario en el frontend o Jquery 
   - [ ] hacer q al borrar el formulario se limpie la opcion de 
validar si esta requerido y al escribir tambien, ponerle un id al
`input`
- [ ]  paginacion instalando el modulo de paginacion
- [ ]  `AuxFunctions::existWidthFK()` -> para validar las llaves foraneas antes de eliminar
# Pendiente
### Investigar
- activar modo **Paranoid** como en Sequalize para evitar tener que estar
siempre checheando el campo activo bd

### bugs
-[x] NavBar configuracion - necesita doble click para que se despliegue, parece ser problemas
de conflicto por varias verciones de boostrap 4.x y jquery
`Eliminar la libreria bootstrap.js nuestra`
- cuando se actualiza el navegador con f5/click en el simbolo de actulizar
no se limpia el request anterior y se envia el mismo nuevamente
- los inputs no tienen un funcionamiento correcto, no permiten desplacamientos con las 
arrow ni seleccion mediante el teclado... algun problema con las librerias incorporadas al parecer
- el filtrar de los `choices` combos creados por los formType algunos no permiten filtrar