## Bugs y Otros detalles de la plantilla
- en el fichero **layout\header.html.twig** se le incorporo el estilo
`style="z-index: 1000"` porque la clase `rd-navbar` tiene un z-index= 1998 y sobrepasa los Modals de boostrap dando algunos conflictos 
```css
 <nav class="rd-navbar 
     style="z-index: 1000" >
```
- los inputs no tienen un funcionamiento correcto, no permiten desplacamientos con las 
arrow ni seleccion mediante el teclado... algun problema con las librerias incorporadas al parecer
- el filtrar de los `choices` combos creados por los formType algunos no permiten filtrar

## Changes
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