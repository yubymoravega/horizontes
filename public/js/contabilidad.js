$(document).ready(function () {

    /**
     * ocultando la Alerta - app.flashes(success|error)
     */
    setTimeout(function () {
        $('#alert__success').addClass('transition-right')
        // $('#alert__success').hide(9000)
    }, 5000)
});

/**
 * Object Msg - Constantes del subsistema de contabilidad
 */
const CONTAB_MSG = {
    REQUIRED_MODULO: 'seleccione un módulo',
    REQUIRED_TIPO_DOC: 'seleccione un tipo de documento',
    REQUIRED_NATURALEZA: 'seleccione una naturaleza',
    REQUIRED_CUENTA: 'seleccione una cuenta',
    REQUIRED_SUBCUENTA: 'seleccione una subcuenta',
    REQUIRED_NOT_BLANK: 'El campo no puede estar vacio!',
}


/**
 * Modal para confirmar la eliminación de algún registro
 * @param { {title , message, url, data} } config objeto con la configuracion
 *
 * - **title** -> titulos del modal,
 * - **message** -> mensaje del cuerpo del modal,
 * - **url** -> url de para cargar cuando se confirme el mensaje,
 * - **data** -> configuracion extra
 *
 */
const onDeleteConfirm = function (config) {
    const {title = '', message = '', url, _token} = config
    $('#confirm__modal').modal('show')
    if (title !== '') $('#confirm__modal__title').html(title)
    if (message !== '') $('#confirm__modal__body').text(message)

    $('#_token__confirm__modal').val(_token)

    $('#confirm__modal__btn_ok').click(function () {
        const form = $('#form__confirm__modal')
        form.attr('action', url)
        form.submit()
    })
}

/**
 * Centralizacion de todas las cargas asyncronas de el Subsistema Contable
 * agrupado por cada uno de los módulos:
 * - config
 * - inventario
 * - rrhh
 * - venta
 * - activoFijo
 */
var contableAsyncLoads = {

    /**
     * Funciones para el modulo de Configuración
     */
    config: {

        /**
         * Carga una el listado de subcuentas y lo asigna en un <select>, si `slect_index != 0` sera el valor seleccionado por defecto
         * @param id_cuenta id de la cuenta por la que se va a buscar
         * @param select_input `<select>` componente HTML que se va a cargar el listado de cuentas
         * @param select_index `<options>` seleccionada por defecto
         */
        loadSubcuentaByCuenta: function (id_cuenta, select_input, select_index = 0) {
            $.ajax({
                url: '/contabilidad/config/centro-costo/getsubcuenta/' + id_cuenta,
                method: 'POST',
                dataType: 'json',
                success: function (result) {
                    select_input.find('option').remove();
                    select_input.append('<option selected = "false" value = "0" disabled> Seleccione la subcuenta</option>');
                    $(result.subcuentas).each(function (pos, valor) {
                        select_input.append('<option value="' + valor.id + '">' + valor.subcuenta + '</option>');
                    })
                    select_input.prop('disabled', false);
                    select_input.val(select_index)
                },
                error: function () {
                    alert('Ha ocurrido un error en el servidor');
                    select_input.prop('disabled', true);
                }
            })
        }
    }
}