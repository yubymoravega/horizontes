$("#admin").click(function () {
    if ($("#admin").hasClass("opened")) {
        $("#admin").removeClass("opened");
    } else {
        $("#admin").addClass("opened");
    }
});

$("#reportes").click(function () {
    if ($("#reportes").hasClass("opened")) {
        $("#reportes").removeClass("opened");
    } else {
        $("#reportes").addClass("opened");
    }
});

$("#servicios").click(function () {
    if ($("#servicios").hasClass("opened")) {
        $("#servicios").removeClass("opened");
    } else {
        $("#servicios").addClass("opened");
    }
});

$("#Configuracion").click(function () {
    if ($("#Configuracion").hasClass("opened")) {
        $("#Configuracion").removeClass("opened");
    } else {
        $("#Configuracion").addClass("opened");
    }
});

$("#Economia").click(function () {
    if ($("#Economia").hasClass("opened")) {
        $("#Economia").removeClass("opened");
    } else {
        $("#Economia").addClass("opened");
    }
});

$("#icon-notification").click(function () {
    window.location.href = "/turismo/reporte/solicitud/";
});

$.ajax({
    type: 'POST',
    data: {'code': '200'},
    url: window.location.protocol + "//" + location.hostname + ":" + window.location.port + "/home/moneda/menu",
    dataType: 'json',
    success: function (data) {

        for (let i = 0; i < data.length; i++) {

            if (data[i].estatus) {
                $("#monedaSys").text(data[i].nombre);
                $('#currency').prepend("<option selected value='" + data[i].code + "' >" + data[i].nombre + "</option>");
            } else {
                $('#currency').prepend("<option  value='" + data[i].code + "' >" + data[i].nombre + "</option>");
            }

        }
    }
});

$.ajax({
    type: 'POST',
    data: {'code': '200'},
    url: window.location.protocol + "//" + location.hostname + ":" + window.location.port + "/home/atender/",
    dataType: 'json',
    success: function (data) {

        let atender = document.getElementById('icon-notification');
        atender.setAttribute('data-count', data);


    }
});

$("#currency").change(function () {
    if ($('#rows_solicitudes_remesas').find('tr').length > 0)
        $('#ModalConfirmChange').modal('show')
    else {
        $.ajax({
            type: 'POST',
            data: {'code': '200'},
            url: window.location.protocol + "//" + location.hostname + ":" + window.location.port + "/home/moneda/select/" + $("#currency option:selected").val(),
            dataType: 'json',
            success: function (data) {
                window.location.href = window.location.pathname;

            }
        });
    }

});

$('#btn_aceptar_change').on('click', function () {
    $.ajax({
        type: 'POST',
        data: {'code': '200'},
        url: window.location.protocol + "//" + location.hostname + ":" + window.location.port + "/home/moneda/select/" + $("#currency option:selected").val(),
        dataType: 'json',
        success: function (data) {
            window.location.href = window.location.pathname;

        }
    });
})

let previous;
$("#currency").on('focus', function () {
    previous = this.value;
});
$('#btn_salir_change').on('click', function () {
    $("#currency").val(previous)
})

function ActualizarCarrito() {
    $('#carrito li').remove();
    let conCarrito = 0;
    let total = null;
    $.ajax({
        type: 'POST',
        data: {'code': '200'},
        url: window.location.protocol + "//" + location.hostname + ":" + window.location.port + "/carrito",
        dataType: 'html',
        success: function (data) {
            data = JSON.parse(data);
            if (data) {
                conCarrito = data.length;
                let total_importe = 0
                for (let i = 0; i < data.length; i++) {
                    let json = data[i].json;
                    $("#carrito").append('<table id="table_carrito" class="w-100 p-0 m-0"></table>');
                    $("#table_carrito").append('<tr id="tr_' + i + '" class="w-100 m-0 p-0"></tr>');
                    let arr = json.data
                    $("#tr_" + i).append('<td colspan="3" class="text-left font-weight-bold text-white">' + json.nombre_servicio + ' (' + arr.length + ')</td>');

                    for (let j = 0; j < arr.length; j++) {
                        const asd = JSON.stringify(arr[j])
                        $("#table_carrito").append('<tr id="tr_' + i + '_' + j + '"></tr>');
                        $("#tr_" + i + '_' + j).append(`<td class="text-left text-secondary"> ${arr[j]['nombreMostrar']} </td>`);
                        $("#tr_" + i + '_' + j).append(`<td class="text-right text-secondary"> ${parseFloat(arr[j]['montoMostrar']).toFixed(2)}</td>`);
                        $("#tr_" + i + '_' + j).append(`<td class="text-right">
                                                                <a class="btn btn-outline-secondary p-1 ml-1" onclick='deleteElementCarrito("${arr[j]['idCarrito']}","${json.id_servicio}")'>
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </td>`);

                    }
                    total_importe += parseFloat(json.total)
                    $("#totalCarrito").text(parseFloat(total_importe).toFixed(2));
                }
                let iconCarrito = document.getElementById('iconCarrito');
            } else {
                conCarrito = 0;
                $("#totalCarrito").text(" $0.00");
            }
            iconCarrito.setAttribute('data-count', conCarrito);
        }
    });
}

function remesaEditar(id) {
    window.location.href = "/remesas.json.editar/" + id;
}

function deleteElementCarrito(idCarrito, id_servicio) {
    $('#confirm__modal').modal('show')
    $('#confirm__modal__body').text('Está seguro que desea eliminar el servicio?')
    $('#_token__confirm__modal').val($('#__token').val())
    $("#confirm__modal__btn_ok").click(function () {
        const path = window.location.pathname
        $('body').append(`
                    <form action='/turismo/gestion-consular/solucitud/delete-carrito'
                         method="post" id='form_delet_element_servicio_carrito'>
                        <input type='hidden' name='id' value='${idCarrito}'/> 
                        <input type='hidden' name='id_servicio' value='${id_servicio}'/>
                        <input type='hidden' name='path' value='${path}'/>
                    </form>`)
        const fomrulario = $('#form_delet_element_servicio_carrito')
        fomrulario.submit()
        fomrulario.remove()
    });
}