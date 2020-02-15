/**
 * Validaciones Ejecución
 * @version 1.0
 * @since 31/07/2014
 * @author Brian Kings
 */

/**
 * Función que verifica el documento soporte de encuesta
 * @param {String} url
 * @returns {Boolean}
 */
function validar_add_ejecucion(url) {
    if (document.getElementById('file_documento_soporte').value === "") {
        mostrarDiv('error_documento_soporte');
        return false;
    }
    document.getElementById('frm_add_ejecucion').action = '?mod=ejecucion&niv=1&task=saveAdd' + url;
    document.getElementById('frm_add_ejecucion').submit();
}
/*
 * Carga los motivos de encuesta incorrecta y cuestionario incorrecto al 
 * cargar el formulario para editar la información
 */
function motivo_carga() {
    if (document.getElementById('txt_cc').value === '2') {
        mostrarDiv('label_3');
        mostrarDiv('txt_mci');
    } else {
        ocultarDiv("label_3");
        ocultarDiv('txt_mci');
    }
    if (document.getElementById('txt_ri').value === '2') {
        mostrarDiv('label_7');
        mostrarDiv('txt_mei');
    } else {
        ocultarDiv('label_7');
        ocultarDiv('txt_mei');
    }
}
/*
 * Oculta o muestra los motivos de encuesta incorrecta y cuestionario incorrecto al 
 * modificar las opciones del formulario encuesta al editar la información
 */
function motivo_onchange(error, elemento, ocultar_pgr, ocultar_res) {
    ocultarDiv(error);
    if (document.getElementById(elemento).value === '2') {
        mostrarDiv(ocultar_pgr);
        mostrarDiv(ocultar_res);
    } else {
        ocultarDiv(ocultar_pgr);
        ocultarDiv(ocultar_res);
    }
}
/**
 * Función que verifica la información de
 * @param {String} form formulario
 * @param {String} url  id_element
 */
function cancelarAccion_ejecucion(form, url) {
    document.getElementById(form).action = '?mod=ejecucion&niv=1&task=list' + url;
    document.getElementById(form).submit();
}
/*
 * Refresca list de ejecución, para actualizar la tabla segun el filtro
 */
function consultar_ejecucion() {
    document.getElementById('frm_list_ejecucion').action = '?mod=ejecucion&niv=1';
    document.getElementById('frm_list_ejecucion').submit();
}
/*
 * Ordena generar el documento xls para mostrar lo que se tiene actualmente en list
 */
function exportar_excel_ejecucion() {
    document.getElementById('frm_list_ejecucion').action = 'modulos/ejecucion/ejecucion_en_excel.php';
    document.getElementById('frm_list_ejecucion').submit();
}
/**
 * Función que verifica los datos requeridos al editar los datos de la encuesta
 * @param {String} url
 * @returns {Boolean}
 */
function validar_edit_ejecucion(url) {
    if (document.getElementById('archivo_anterior').value === '') {
        if (document.getElementById('file_documento_soporte').value == "") {
            mostrarDiv('error_documento_soporte');
            return false;
        }
    }
    if (document.getElementById('txt_fecha').value == '') {
        mostrarDiv('error_fecha');
        return false;
    }
    if (document.getElementById('txt_cc').value == '-1') {
        mostrarDiv('error_cc');
        return false;
    }
    if (document.getElementById('txt_cc').value == '2') {
        if (document.getElementById('txt_mci').value == '') {
            mostrarDiv('error_mci');
            return false;
        }
    } else if (document.getElementById('txt_cc').value == '1') {
        document.getElementById('txt_mci').value = '';
    }
    if (document.getElementById('txt_rf').value == '-1') {
        mostrarDiv('error_rf');
        return false;
    }
    if (document.getElementById('txt_vi').value == '-1') {
        mostrarDiv('error_vi');
        return false;
    }
    if (document.getElementById('txt_ri').value == '-1') {
        mostrarDiv('error_ri');
        return false;
    }
    if (document.getElementById('txt_ri').value == '2') {
        if (document.getElementById('txt_mei').value == '') {
            mostrarDiv('error_mei');
            return false;
        }
    }
    else if (document.getElementById('txt_ri').value == '1') {
        document.getElementById('txt_mei').value = '';
    }
    if (document.getElementById('txt_usuario').value == '-1') {
        mostrarDiv('error_usuario');
        return false;
    }
    document.getElementById('frm_edit_ejecucion').action = '?mod=ejecucion&task=saveEdit&niv=1' + url;
    document.getElementById('frm_edit_ejecucion').submit();
}
/*
 * Función para pasar de list a prelist en ejecucion.php
 */
function volver_pre_list() {
    document.getElementById('frm_list_ejecucion').action = '?mod=ejecucion&niv=1';
    document.getElementById('frm_list_ejecucion').submit();
}
/*
 * Salta de una pagina a otra sin necesidad de interaccion del usuario
 * @param {String} url
 * @param {String} form
 */
function salto_automatico(url, form) {
    document.getElementById(form).action = url;
    document.getElementById(form).submit();
}
/*
 * Cambia la visibilidad de las seccion actual a visible para ser diligenciada
 * y oculta las demás secciones
 * * @param {String} url
 */
function cambiarVisibilidad(url) {
    var inicio = parseInt(document.getElementById('hdd_inicio').value);
    var fin = parseInt(document.getElementById('hdd_fin').value);
    for (i = inicio; i <= fin; i++) {
        var sec = 'sec_' + i;
        ocultarDiv(sec);
        var secT = 'secT_' + i;
        ocultarDiv(secT);
    }
    var seccionActual = parseInt(document.getElementById('hdd_seccion').value);
    mostrarDiv('sec_' + seccionActual);
    mostrarDiv('secT_'+seccionActual);
    validar_saltar_automatico(url);
}
/*
 * Valida cuantas secciones tienen todas sus preguntas ocultas, si esto se cumple 
 * salta hasta la seccion donde se encuentre una pregunta visible
 * @param {String} url
 */
function validar_saltar_automatico(url) {
    var seccionActual = parseInt(document.getElementById('hdd_seccion').value);
    var num_pre_inicio = parseInt(document.getElementById('hdd_pre_inicio_' + seccionActual).value);
    var num_pre_fin = parseInt(document.getElementById('hdd_pre_fin_' + seccionActual).value);
    var saltoSeccion;
    saltoSeccion = '0';
    for (i = num_pre_inicio; i <= num_pre_fin; i++) {
        if (document.getElementById(i).style.visibility === 'visible' || document.getElementById(i).style.visibility === '') {
            saltoSeccion = '1';
        }
    }
    if (saltoSeccion === '0') {
        if (document.getElementById('hdd_seccion_atras').value === '') {
            document.getElementById('hdd_seccion_atras').value = 0;
        }
        document.getElementById('hdd_seccion_atras').value = parseInt(document.getElementById('hdd_seccion_atras').value) + 1;
        document.getElementById('hdd_seccion').value = parseInt(document.getElementById('hdd_seccion').value) + 1;
        cambiarVisibilidad();
    }
}
/*
 * Saltar de la seccion actual a la siguiente siempre y cuando no sea la utlima
 * @param {String} url
 */
function saltar_seccion(url) {
    var num_sec = parseInt(document.getElementById('hdd_seccion').value);
    var fin = parseInt(document.getElementById('hdd_fin').value);
    //cambio seccion
    if (num_sec < fin) {
        document.getElementById('hdd_seccion').value = num_sec + 1;
    }
    document.getElementById('frm_encuestas').action = '?mod=ejecucion&niv=1&task=encuesta&niv=1&id_element=' + url;
    document.getElementById('frm_encuestas').submit();
}
/*
 * Regresar una seccion, verifica si se ha realizado un validar_salto automatico
 * para devolver las secciones correspondientes
 */
function devolver_seccion() {
    var num_sec = parseInt(document.getElementById('hdd_seccion').value);
    var inicio = parseInt(document.getElementById('hdd_inicio').value);
    var fin = parseInt(document.getElementById('hdd_fin').value);
    if (num_sec > inicio) {
        for (i = inicio; i <= fin; i++) {
            var sec = 'sec_' + i; 
            ocultarDiv(sec);
            var secT = 'secT_' + i;
            ocultarDiv(secT);
        }
        if (document.getElementById('hdd_seccion_atras').value === '') {
            document.getElementById('hdd_seccion_atras').value = 0;
        }
        document.getElementById('hdd_seccion').value = num_sec - 1 - parseInt(document.getElementById('hdd_seccion_atras').value);
        mostrarDiv('sec_' + (document.getElementById('hdd_seccion').value));
        mostrarDiv('secT_' + (document.getElementById('hdd_seccion').value));
        document.getElementById('hdd_seccion_atras').value = parseInt(0);
    }
}
/*
 * oculta las preguntas al cargar las respuestas de una encuesta ya diligenciada
 * @param {array} arreglo_preguntas
 */
function ocultar_preguntas(arreglo_preguntas) {
    arreglo_preguntas = arreglo_preguntas.split("/");
    for (j = 0; j < (arreglo_preguntas.length); j++) {
        ocultarDiv(arreglo_preguntas[j]);
        ocultarDiv('prg_' + arreglo_preguntas[j]);
        ocultarDiv('res_' + arreglo_preguntas[j]);
    }
    var seccionActual = parseInt(document.getElementById('hdd_seccion').value);
    var num_pre_inicio = parseInt(document.getElementById('hdd_pre_inicio_' + seccionActual).value);
    var num_pre_fin = parseInt(document.getElementById('hdd_pre_fin_' + seccionActual).value);
    //P16 individuos
    if (num_pre_inicio <= 60 && 60 >= num_pre_fin) {
        for (i = 60; i <= 65; i++) {
            if (document.getElementById(i).value !== '') {
                for (i = 66; i <= 71; i++) {
                    ocultarDiv(i);
                    ocultarDiv('prg_' + i);
                    ocultarDiv('res_' + i);
                }
            }
        }
    }
}
/*
 * Oculta o muestra automaticamente las preguntas que se evitan al seleccionar
 *  un respuesta que conlleva a otra pregunta que no es la que continua
 * @param {Integer} idPregunta
 * @param {array} arreglo_saltos
 * @param {Integer} tipo  tipo de pregunta
 */
function saltar_pregunta_onChange(idPregunta, arreglo_saltos, tipo) {
    if (document.getElementById('error_pregunta_' + idPregunta).style.visibility !== 'hidden') {
        ocultarDiv('error_pregunta_' + idPregunta);
    }
    arreglo_saltos = arreglo_saltos.split("/");
    var id_salto;
    var maxPregunta = arreglo_saltos[1];
    if (tipo === '2') {
        for (j = 0; j < arreglo_saltos.length; j += 2) {
            if (document.getElementById(idPregunta).value === arreglo_saltos[j]) {
                id_salto = parseInt(arreglo_saltos[j + 1]);
            }
            if (arreglo_saltos[j - 1] < arreglo_saltos[j + 1]) {
                maxPregunta = arreglo_saltos[j + 1];
            }
        }
    }
    else if (tipo === '3') {
        if (document.getElementById('hdd_checked_' + idPregunta).value === '') {
            document.getElementById('hdd_checked_' + idPregunta).value = 'checked';
        } else {
            document.getElementById('hdd_checked_' + idPregunta).value = '';
        }
        for (j = 0; j < arreglo_saltos.length; j += 2) {
            if (document.getElementById(idPregunta).value === arreglo_saltos[j] && document.getElementById('hdd_checked_' + idPregunta).value === 'checked') {
                id_salto = parseInt(arreglo_saltos[j + 1]);
                document.getElementById('hdd_checked_' + idPregunta).value = 'checked';
            }
            if (j > 0) {
                if (arreglo_saltos[j - 1] < arreglo_saltos[j + 1]) {
                    maxPregunta = arreglo_saltos[j + 1];
                }
            }
        }
    }
    else if (tipo === '1') {
        var verifica = false;
        if (document.getElementById(idPregunta).value !== '' && document.getElementById('hdd_checked_' + idPregunta).value !== 'checked') {
            id_salto = parseInt(arreglo_saltos[1]);
            document.getElementById('hdd_checked_' + idPregunta).value = 'checked';
            verifica = true;
        }
        if (verifica === false) {
            document.getElementById('hdd_checked_' + idPregunta).value = '';
        }
    }
    else if (tipo === '5') {
        if (document.getElementById(idPregunta).value !== '') {
            id_salto = parseInt(arreglo_saltos[1]);
        }
    }
    var id = parseInt(idPregunta);
    //Caso especial pregunta P16 individuos
    if (60 <= id && id <= 65) {
        maxPregunta = 72;
        for (i = 60; i <= 65; i++) {
            if (document.getElementById(i).value !== '') {
                id_salto = 72;
            }
        }
        id = 65;
    }
    if (id < maxPregunta) {
        //mostrar las del valor anterior
        for (i = (id + 1); i <= maxPregunta; i++) {
            mostrarDiv(i);
            mostrarDiv('prg_' + i);
            mostrarDiv('res_' + i);
        }
    } else {
        for (i = maxPregunta; i <= id; i++) {
            mostrarDiv(i);
            mostrarDiv('prg_' + i);
            mostrarDiv('res_' + i);
        }
    }
    //ocultar las del nuevo valor
    if (id < id_salto) {
        var h = (id + 1);
        while (h < id_salto) {
            ocultarDiv(h);
            ocultarDiv('prg_' + h);
            ocultarDiv('res_' + h);
            h++;
        }
    } else if (id > id_salto) {
        var h = (id - 1);
        while (h > id_salto) {
            ocultarDiv(h);
            ocultarDiv('prg_' + h);
            ocultarDiv('res_' + h);
            h--;
        }
    }
}
/*
 * verifica si ya se completo la encuesta y ordena finalizar la encuesta
 * @param {String} url  id_element
 */
function save_seccion_final(url) {
    var num_sec = parseInt(document.getElementById('hdd_seccion').value);
    var fin = parseInt(document.getElementById('hdd_fin').value);
    if (num_sec === fin) {
        save_seccion(url);
    }
}
/*
 * verifica si ya se completo la seccion y permite avanzar a la siguiente seccion
 * @param {String} url  id_element
 */
function save_seccion(url) {
    //Pregunta Desarrollo de la encuesta obligatoria
    var num_sec = parseInt(document.getElementById('hdd_seccion').value);
    var prg_seccion = document.getElementById('arreglo_prg_' + num_sec).value;
    var num_pre_fin = parseInt(document.getElementById('hdd_pre_fin_' + num_sec).value);
    prg_seccion = prg_seccion.split("/");
    for (i = 0; i < prg_seccion.length; i++) {
        //esta visible?
        if (document.getElementById(prg_seccion[i]).style.visibility === 'visible' || document.getElementById(prg_seccion[i]).style.visibility === '') {
            if (document.getElementById(prg_seccion[i]).value === '' || document.getElementById(prg_seccion[i]).value === '-1') {
                mostrarDiv('error_pregunta_' + prg_seccion[i]);
                return false;
            }
        }
        if (((i + 1) !== prg_seccion.length || parseInt(prg_seccion[i]) !== num_pre_fin) && (document.getElementById(prg_seccion[i]).style.visibility === 'visible' || document.getElementById(prg_seccion[i]).style.visibility === '')) {
            var error = false;
            var ultima_pregunta_hijo;
            //alert(prg_seccion[i]+'-'+prg_seccion[i + 1]);
            if ((parseInt(prg_seccion[i]) + 1) !== parseInt(prg_seccion[i + 1])) {
                if ((i + 1) !== prg_seccion.length) {
                    ultima_pregunta_hijo = parseInt(prg_seccion[i + 1]) - 1;
                } else if (prg_seccion[i] !== num_pre_fin) {
                    ultima_pregunta_hijo = num_pre_fin;
                }
                //alert(ultima_pregunta_hijo);
                error = true;
                for (j = (parseInt(prg_seccion[i]) + 1); j <= ultima_pregunta_hijo; j++) {
                    if (document.getElementById(j).value !== '') {
                        if (document.getElementById(j).value !== '1') {
                            error = false;
                        } else {
                            try {
                                if (document.getElementById('hdd_checked_' + j).value === 'checked') {
                                    error = false;
                                }
                            }
                            catch (e) {
                                error = false;
                            }
                        }
                    }
                }
            }
            if (error === true) {
                mostrarDiv('error_pregunta_' + parseInt(ultima_pregunta_hijo));
                return false;
            }
        }
    }
    //validar edad
    if (num_sec === 3) {
        if ((parseInt(document.getElementById('9').value)) <= 0 || (parseInt(document.getElementById('9').value)) > 99) {
            mostrarDiv('error_pregunta_9');
            return false;
        }
    }
    if (num_sec === 15) {
        if ((parseInt(document.getElementById('163').value)) <= 0 || (parseInt(document.getElementById('163').value)) > 99) {
            mostrarDiv('error_pregunta_163');
            return false;
        }
    }
    //validar multiple respuesta
    if (num_sec === 4) {
        if (document.getElementById('22').style.visibility === 'visible' || document.getElementById('22').style.visibility === '') {
            if (document.getElementById('hdd_checked_22_28').value + document.getElementById('hdd_checked_22_29').value +
                    document.getElementById('hdd_checked_22_30').value + document.getElementById('hdd_checked_22_31').value === '') {
                mostrarDiv('error_pregunta_22_31');
                return false;
            }
        }
    }
    if (num_sec === 17) {
        if (document.getElementById('169').style.visibility === 'visible' || document.getElementById('169').style.visibility === '') {
            if (document.getElementById('hdd_checked_169_196').value + document.getElementById('hdd_checked_169_197').value +
                    document.getElementById('hdd_checked_169_198').value + document.getElementById('hdd_checked_169_199').value === '') {
                mostrarDiv('error_pregunta_169_199');
                return false;
            }
        }
    }
    if (num_sec === 22) {
        if (document.getElementById('194').style.visibility === 'visible' || document.getElementById('194').style.visibility === '') {
            if (document.getElementById('hdd_checked_194_238').value + document.getElementById('hdd_checked_194_239').value +
                    document.getElementById('hdd_checked_194_240').value + document.getElementById('hdd_checked_194_241').value === '') {
                mostrarDiv('error_pregunta_194_241');
                return false;
            }
        }
    }
    document.getElementById('frm_encuesta').action = '?mod=ejecucion&task=saveEncuesta&niv=1&id_element=' + url;
    document.getElementById('frm_encuesta').submit();

}
/*
 * Envia la orden de cargar el formulario para importar la planeacion 
 * @param {String} form
 * @param {String} url
 */
function importar_excel_ejecucion(form, url) {
    document.getElementById(form).action = '?mod=ejecucion&task=carga&niv=1&id_element=' + url;
    document.getElementById(form).submit();
}
/*
 * valida que se ingrese un archivo a la hora de realizar la carga masiva
 * @param {String} url
 * @returns {Boolean}
 */
function validar_carga_ejecucion(url) {
    if (document.getElementById('file_documento_carga').value === '') {
        mostrarDiv('error_documento_carga');
        return false;
    }
    document.getElementById('frm_carga_ejecucion').action = '?mod=ejecucion&task=saveCarga&niv=1&id_element=' + url;
    document.getElementById('frm_carga_ejecucion').submit();
}
/*
 * Envia la orden de exportar las encuestas
 */
function exportar_encuesta() {
    document.getElementById('frm_list_ejecucion').action = 'modulos/ejecucion/encuesta_exportar.php';
    document.getElementById('frm_list_ejecucion').submit();
}
