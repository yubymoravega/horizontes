

$( "#admin" ).click(function() {
    if($("#admin").hasClass("opened")){
        $( "#admin" ).removeClass( "opened" );      
    }else{
        $("#admin").addClass("opened");
    }
  });

$( "#reportes" ).click(function() {
    if($("#reportes").hasClass("opened")){
        $( "#reportes" ).removeClass( "opened" );      
    }else{
        $("#reportes").addClass("opened");
    }
  });

  $( "#servicios" ).click(function() {
    if($("#servicios").hasClass("opened")){
        $( "#servicios" ).removeClass( "opened" );      
    }else{
        $("#servicios").addClass("opened");
    }
  });

  $( "#Configuracion" ).click(function() {
    if($("#Configuracion").hasClass("opened")){
        $( "#Configuracion" ).removeClass( "opened" );      
    }else{
        $("#Configuracion").addClass("opened");
    }
  });

  $( "#Economia" ).click(function() {
    if($("#Economia").hasClass("opened")){
        $( "#Economia" ).removeClass( "opened" );      
    }else{
        $("#Economia").addClass("opened");
    }
  });

$( "#icon-notification" ).click(function() {
    window.location.href ="/turismo/reporte/solicitud/";
  });

$.ajax({
    type: 'POST',
    data: {'code' : '200'},
    url: window.location.protocol+"//"+location.hostname+":"+window.location.port+"/home/moneda/menu",
    dataType: 'json',
    success: function (data) { 
      
        for(let i = 0; i < data.length; i++) {
           
            if(data[i].estatus){
                $("#monedaSys").text(data[i].nombre);
                $('#currency').prepend("<option selected value='"+data[i].code+"' >"+data[i].nombre+"</option>");
            }else{
                $('#currency').prepend("<option  value='"+data[i].code+"' >"+data[i].nombre+"</option>");
            }
           
        }
    }}); 

    $.ajax({
        type: 'POST',
        data: {'code' : '200'},
        url: window.location.protocol+"//"+location.hostname+":"+window.location.port+"/home/atender/",
        dataType: 'json',
        success: function (data) { 
          
            let  atender = document.getElementById('icon-notification');
            atender.setAttribute('data-count',data);


        }}); 

    $( "#currency" ).change(function() {
       
        $.ajax({
            type: 'POST',
            data: {'code' : '200'},
            url: window.location.protocol+"//"+location.hostname+":"+window.location.port+"/home/moneda/select/"+$( "#currency option:selected" ).val(),
            dataType: 'json',
            success: function (data) { 
                window.location.href = window.location.pathname;
        
            }}); 

      });


function ActualizarCarrito() {

$('#carrito li').remove();

let conCarrito = 0;
let total = null;
$.ajax({
type: 'POST',
data: {'code' : '200'},
url: window.location.protocol+"//"+location.hostname+":"+window.location.port+"/carrito",
dataType: 'html',
success: function (data) {

data = JSON.parse(data); 

if(data){
    conCarrito = data.length;

    for(let i = 0; i < data.length; i++) {
        let json = JSON.parse(data[i].json);  
    
         $("#carrito").append('<li id="li'+i+'"></li>');
         $("#li"+i).append('<div id="div'+i+'"'+' class="rd-navbar-product-caption"></div>'+ '<a class="svgCarrito" onClick="remesaBorrar('+data[i].id+');" ><svg  width="1em" height="1em" viewbox="0 0 16 16" class="iconCarritoDelete box bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg></a>');
         $("#div"+i).append('<a onClick="remesaEditar('+data[i].id+');"> <h6 id="h6'+i+'"'+' class="rd-navbar-product-title">'+json.servicio+' '+json.primerNombre+' '+json.primerApellido+'</h6></a>');
         $("#h6"+i).append('<p class="rd-navbar-product-price">$'+data[i].total+'</p>');
        
         total = Number(total) + Number(data[i].total);
         $("#totalCarrito").text(data[i].moneda+" $"+total);
         let  iconCarrito = document.getElementById('iconCarrito');
       
    }

}else{conCarrito= 0;  $("#totalCarrito").text(" $0.00");}

iconCarrito.setAttribute('data-count',conCarrito);


}}); }

function remesaEditar(id) {
    window.location.href = "/remesas.json.editar/"+id;
                     }

  function remesaBorrar(id) {
    $('#confirm__modal').modal('show')

    $( "#confirm__modal__btn_ok" ).click(function() {

        $.ajax({
            type: 'POST',
            data: {'code' : '200'},
            url: window.location.protocol+"//"+location.hostname+":"+window.location.port+"/remesas.json.borrar/"+id,
            dataType: 'html',
            success: function (data) {

                window.location.href = "/home";
            
                
            }}); 

            
        
      });
                     }


