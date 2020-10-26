// conseloe.log() function
/**
 * Avreviatura de console.log()
 * @type {(message?: any, ...optionalParams: any[]) => void}
 */
var cl = console.log

$(document).ready(function () {

    /**
     * Enable popovers everywhere
     */
    $(function () {
        $('[data-toggle="popover"]').popover()
    })

    /**
     * ocultando la Alerta - app.flashes(success|error)
     */
    setTimeout(function () {
        $('#alert__success').addClass('transition-right')
        // $('#alert__success').hide(9000)
    }, 5000)


    /**
     * ADD Validations to --- Validator.JS ---
     */
    jQuery.validator.addMethod("num-letter", function (value, element) {
        // allow any non-whitespace characters as the host part
        return this.optional(element) || /^[A-Za-z0-9]+$/g.test(value);
    }, 'Please enter a valid email address.')

    /**
     * Code JS to <component> `input-multiselect-modal-type` -
     */
    $('[input-multiselect-modal-type]').on('click', function () {

        const parent_id = $(this).attr('immt-parent')
        const parent = $(parent_id).val() || '';
        const url = $(this).attr('immt-url') + '/' + parent
        const modal = $('#input-multiselt-modal')
        const table = modal.find('table')
        const input_parent = $(this)
        const key_checks = $(this).attr('immt-key') || 'id'

        if (parent_id && parent === '') {
            alertTemplate('Debe llenar los campos previos', 'danger')
            return
        }
        loadingModal.show()
        // eliminar datos tabla
        modal.find('h4').text($(this).attr('immt-title'))

        $.ajax({
            url,
            method: 'POST',
            dataType: 'json',
            success: function (result) {
                loadingModal.close()
                table.find('tr').remove();
                const data = result.data
                let th_create = false;
                $(data).each((poss, valor) => {
                    const keys = Object.keys(valor)
                    let keysToTd = ''
                    let ckecked = input_parent.val().includes(valor[key_checks]) ? 'checked' : ''
                    let ths = ''
                    for (const key of keys) {
                        keysToTd += `<td style="font-weight:400;"> ${valor[key]} </td>`
                        if (!th_create)
                            ths += `<th>${key} </th>`
                    }
                    if (!th_create) {
                        table.append(`<thead class="thead-dark"> <th scope="col-1" style="width: 10px">Sel.</th> ${ths}</thead>`)
                        th_create = true
                    }

                    table.append(
                        `<tr> 
                            <td style="font-weight:400;"> 
                                <input type="checkbox" ${ckecked} style="margin-left: auto;" data="${valor[key_checks]}">
                            </td>
                            ${keysToTd}
                        </tr>
                        `)
                })
                modal.modal('show')
            }
        })

        // Click en el boton de seleccionar y asiganar los valores al imput
        $('#btnok-input-multiselt-modal').one('click', function () {

            const checks = $(table).find('input:checked')
            let data = ''
            for (let i = 0; i < checks.length; i++) {
                data += $(checks[i]).attr('data') + ' - '
            }
            input_parent.val(data.substr(0, data.length - 2))
            modal.modal('hide')
        })

    })
})
;

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
    REQUIRED_OBLIGATORIO: 'campo obligatorio!',
    FORMAT_NO_CUENTA: 'el No. de la cuenta solo acepta letras y números',
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
    const {title = '', message = '', url, _token, page = null} = config
    $('#confirm__modal').modal('show')
    if (title !== '') $('#confirm__modal__title').html(title)
    if (message !== '') $('#confirm__modal__body').text(message)

    $('#_token__confirm__modal').val(_token)
    $('#page__confirm__modal').val(page)

    $('#confirm__modal__btn_ok').click(function () {
        const form = $('#form__confirm__modal')
        $('#confirm__modal').modal('hide')
        loadingModal.show('Eliminando...')
        form.attr('action', url)
        form.submit()
    })
}

/**
 * funcion que crea las alertas para el usuario dependiendo de la configuración
 *
 * @param msg - mensaje de la alerta
 * @param type - genera la clase css para el color de la alerta `alert-type` (success por defecto)
 * @param time - tiempo de espera del mensaje para desaparecer (4s por defecto)
 */
const alertTemplate = (msg, type = 'success', time = 4000) => {
    const template =
        `<div class="toasts-alert alert alert-${type} fade show" role="alert">
            <span>${msg}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" class="ml-2 text-white">&times;</span>
            </button>
        </div>`;

    $('body').append(template)
    setTimeout(() => {
        $('.toasts-alert').addClass('transition-right')
        setTimeout(() => $('.toasts-alert').remove(), 1000)
    }, time)
}

loadingModal = {
    show: function (msg = 'Procesando...') {
        $('#loading-modal').modal('show')
        $('#loading-modal-msg').text(msg)
    },
    close: function () {
        setTimeout(function () {
            $('#loading-modal').modal('hide');
        }, 500)
    }
}

miniLoadin = {
    show: (config) => {
        const {msg = 'Cargando...', target} = config

        $(target).append(
            `<div mili-loading class="d-flex justify-content-center">
                <span class="spinner-border text-primary" style="width: 1.3rem; height: 1.3rem;" role="status" aria-hidden="true"></span>
                <span class="text-primary ml-2" id="loading-modal-msg"> ${msg}</span>
            </div>`
        )
    },
    close: () => {
        $('[mili-loading]').remove()
    }
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
         * Carga una el listado de subcuentas y lo asigna en un <select>, si
         `slect_index != 0`
         sera el valor seleccionado por defecto
         * @param id_cuenta id de la cuenta por la que se va a buscar
         * @param select_input
         `<select>`
         componente HTML que se va a cargar el listado de cuentas
         * @param select_index
         `<options>`
         seleccionada por defecto
         */
        loadSubcuentaByCuenta: function (id_cuenta, select_input, select_index = 0) {
            loadingModal.show('Cargando subcuentas...')
            $.ajax({
                url: '/contabilidad/config/cuenta/get-subcuentas/' + id_cuenta,
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
                    loadingModal.close()
                },
                error: function () {
                    alert('Ha ocurrido un error en el servidor');
                    select_input.prop('disabled', true);
                    loadingModal.close()
                }
            })
        }
    }
}

const getNro = function (nro) {
    $arr = nro.split(' - ');
    if ($arr)
        return $arr[0];
    return '';
}