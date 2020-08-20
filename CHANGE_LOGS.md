# Changes
## Semana #2 (10-08-2020)
#### Integrando Paranoid
1. hacer que todas las clases `EntityNameRepositorys` extiendan de `ParanoidEntityRepository.php`
y el contructor asigne el `entityClass` y `registry` ejemplo:
```php
class AlmacenRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(Almacen::class);
        $this->setRegistry($registry);
        parent::__construct();
    }
}
```
2. Eliminar la restrincion unica de las `Entitys`, para realizar la validacion mediante codigo
manteniendo la notacion `@Assert\NotBlank(message="contabilidad.config.descripcion_not_blank")`
Ejemplo con descripción de Almacén: 
```php
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="contabilidad.config.descripcion_not_blank")
     */
    private $descripcion;

```
#### Bugs y Otros detalles de la plantilla
- en el fichero **layout\header.html.twig** se le incorporo el estilo
`style="z-index: 1000"` porque la clase `rd-navbar` tiene un z-index= 1998 y sobrepasa los Modals de boostrap dando algunos conflictos 
```css
 <nav class="rd-navbar 
     style="z-index: 1000" >
```

## Semana #1 (04-08-2020)
- base.html.twig
1. Modificar el color de la barra de titulo del modal, para buscar uniformidad con el estilo de la plantilla
2. Modificar el boton de cancelar para seguir estandar de nosotros, btn cancelar en la ezquina izquierda y en la parte derecha los btn de aplicar y aceptar, para las vista que asi lo requieran
3. Revisar la vista de almacen que hice unos detalles que leandro tiene que revisar 

#### Configuracion inicial
revisar los sms de confirmacion de las acciones que no salen.<br>
**Unidad**
1. Asi es como trabajaremos con los formularios de 2 a 4 campos, para que se vean de una forma agradable, desde el JQuery se realiza todo
 > Debemos applicar el estandar visual para que las vistas sean compatibles con la plantilla****
     