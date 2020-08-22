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
 * Object Msg
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
 * @param config { {title , message, url, data} }
 * {
 *      **title** -> titulos del modal,
 *      **message** -> mensaje del cuerpo del modal,
 *      **url** -> url de para cargar cuando se confirme el mensaje,
 *      **data** -> configuracion extra
 * }
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