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