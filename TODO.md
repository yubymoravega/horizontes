# TODO - Contabilidad
### Configuración
- [x] Crear las Entidadesde
- [ ] CRUD por cada Entidad
    - [x] Config inicial 
    - [x] Almacén `u`
    - [ ] Centro Costo ---leo 
    - [x] Cuenta 
    - [x] Elemento de Gasto
    - [ ] Grupo Activo ---camilo
    - [x] Instrumento Cobro `u`
    - [x] Modulo `u`
    - [x] Moneda `u`
    - [x] Subcuenta
    - [x] Tasa Cambio---camilo
    - [x] Tipo Documento `u`
    - [x] Tipo Documento Activo Fijo `u`
    - [x] Tipo Movimiento `u`
    - [x] Unidad
    - [x] Unidad Medida `u`
- Refactorizacion el CODIGO
   - Crear clase Unica para CRUD como la de (descrip/nombre)
   - Ajustar el codigo al estilo `php bin/console make:crud` del ejemplo TestCrd
   - `php bin/console debug:Route` -> Revisar los metodos q acceden a las controladoras 
- hacer q al borrar el formulario se limpie la opcion de 
validar si esta requerido y al escribir tambien, ponerle un id al
`input`
- paginacion instalando el modulo de paginacion
- los campos eliminados(activo=false) de la base de datos
que se reactiven(activo=true) cuado se add nuevamente en nomencladores de (Descripcion/nombre)
- `AuxFunctions::existWidthFK()` -> para validar las llaves foraneas antes de eliminar
# Pendiente
### Investigar
- activar modo **Paranoid** como en Sequalize para evitar tener que estar
siempre checheando el campo activo bd

### bugs
- NavBar configuracion - necesita doble click para que se despliegue, parece ser problemas
de conflicto por varias verciones de boostrap 4.x y jquery
- cuando se actualiza el navegador con f5/click en el simbolo de actulizar
no se limpia el request anterior y se envia el mismo nuevamente

### Cambios realizados:<br>
- base.html.twig
1. Modificar el color de la barra de titulo del modal, para buscar uniformidad con el estilo de la plantilla
2. Modificar el boton de cancelar para seguir estandar de nosotros, btn cancelar en la ezquina izquierda y en la parte derecha los btn de aplicar y aceptar, para las vista que asi lo requieran
3. Revisar la vista de almacen que hice unos detalles que leandro tiene que revisar 

#### Configuracion inicial
revisar los sms de confirmacion de las acciones que no salen.<br>
**Unidad**
1. Asi es como trabajaremos con los formularios de 2 a 4 campos, para que se vean de una forma agradable, desde el JQuery se realiza todo
 > Debemos applicar el estandar visual para que las vistas sean compatibles con la plantilla****
     