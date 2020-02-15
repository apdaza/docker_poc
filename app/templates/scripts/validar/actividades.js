function validar_add_actividad() {

    if (document.getElementById('sel_estado_add').value == '-1') {
        mostrarDiv('error_estado');
        return false;
    }

    if (document.getElementById('sel_subsistema_add').value == '-1') {
        mostrarDiv('error_subsistema');
        return false;
    }

    if (document.getElementById('txt_descripcion_add').value == '') {
        mostrarDiv('error_descripcion');
        return false;
    }

    if (document.getElementById('txt_fecha_inicio_add').value == '') {
        mostrarDiv('error_fecha_inicio');
        return false;
    }

    if (document.getElementById('txt_fecha_fin_add').value == '') {
        mostrarDiv('error_fecha_fin');
        return false;
    }

    if (document.getElementById('txt_inconvenientes_add').value == '') {
        mostrarDiv('error_inconvenientes');
        return false;
    }

    document.getElementById('frm_add_actividad').action = '?mod=actividades&niv=1&task=saveAdd';
    document.getElementById('frm_add_actividad').submit();
}

function validar_edit_actividad() {

    if (document.getElementById('sel_estado_edit').value == '-1') {
        mostrarDiv('error_estado');
        return false;
    }

    if (document.getElementById('sel_subsistema_edit').value == '-1') {
        mostrarDiv('error_subsistema');
        return false;
    }

    if (document.getElementById('txt_descripcion_edit').value == '') {
        mostrarDiv('error_descripcion');
        return false;
    }

    if (document.getElementById('txt_fecha_inicio_edit').value == '') {
        mostrarDiv('error_fecha_inicio');
        return false;
    }

    if (document.getElementById('txt_fecha_fin_edit').value == '') {
        mostrarDiv('error_fecha_fin');
        return false;
    }

    if (document.getElementById('txt_inconvenientes_edit').value == '') {
        mostrarDiv('error_inconvenientes');
        return false;
    }

    document.getElementById('frm_edit_actividad').action = '?mod=actividades&niv=1&task=saveEdit';
    document.getElementById('frm_edit_actividad').submit();
}
