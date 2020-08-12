$(document).ready(function () {

    /**
     * ocultando la Alerta - app.flashes(success)
     */
    setTimeout(function () {
        $('#alert__success').addClass('transition-right')
    }, 4000)
    $('#alert__success').hide(5000)


});


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
    const {title = '', message = '', url, data = []} = config
    $('#confirm__modal').modal('show')
    if (title !== '') $('#confirm__modal__title').html(title)
    if (message !== '') $('#confirm__modal__body').text(message)

    $('#confirm__modal__btn_ok').click(function () {
        window.location.replace(url);
    })
}