/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function validar_agregar_estudio(form,accion){
    
    var codigo = document.getElementById('txt_codigo');
    var region = document.getElementById('txt_region');
    var departamento = document.getElementById('txt_departamento');
    var municipio = document.getElementById('txt_municipio');
    var grupo = document.getElementById('txt_grupo');
    var meta = document.getElementById('txt_meta');
    var tipo_b = document.getElementById('txt_tipo_b');
    var nombreSede = document.getElementById('txt_nombreSede');
    var direccion_sede = document.getElementById('txt_direccion_sede');
    var elegibilidad = document.getElementById('txt_elegibilidad');
    var fecha_r = document.getElementById('txt_fecha_real');
    var fecha_v = document.getElementById('txt_fecha_val');
    var estado = document.getElementById('txt_estado');
    var pri_nombre = document.getElementById('txt_pri_nombre');
    var pri_apellido = document.getElementById('txt_pri_apellido');
    var cargo = document.getElementById('txt_cargo');
    var celular = document.getElementById('txt_celular');
    var archivo = document.getElementById('file_comunicado_add');

    if(codigo.value == ''){
      codigo.focus();
       mostrarDiv('error_codigo');
       return false;
    }
    if(tipo_b.value == -1){
      tipo_b.focus();
       mostrarDiv('error_tipo_b');
       return false;
    }
    if(grupo.value == -1){
      grupo.focus();
       mostrarDiv('error_grupo');
       return false;
    }
    if(meta.value == -1){
       meta.focus();
       mostrarDiv('error_meta');
       return false;
    }
    if(nombreSede.value == ''){
       nombreSede.focus();
       mostrarDiv('error_nombreSede');
       return false;
    }
    if(direccion_sede.value == ''){
       direccion_sede.focus();
       mostrarDiv('error_direccion_sede');
       return false;
    }
    if(region.value == -1){
       region.focus();
       mostrarDiv('error_region');
       return false;
    }
    if(departamento.value == -1){
       departamento.focus();
       mostrarDiv('error_departamento');
       return false;
    }
    if(municipio.value == -1){
        municipio.focus();
        mostrarDiv('error_municipio');
       return false;
    }
    if(elegibilidad.value == -1){
        elegibilidad.focus();
        mostrarDiv('error_elegibilidad');
       return false;
    }
    if(estado.value == -1){
        estado.focus();
        mostrarDiv('error_estado');
       return false;
    }
    if(fecha_r.value =='0000-00-00' || fecha_r.value ==''){
        fecha_r.focus();
        mostrarDiv('error_fecha_real');
       return false;
    }
    
    if(fecha_v.value == '0000-00-00'|| fecha_v.value ==''){
       fecha_v.focus();
       mostrarDiv('error_fecha_val');
       return false;
    }
    if(convertirFecha(fecha_r.value)>convertirFecha(fecha_v.value)){
        fecha_r.focus();
        fecha_r.focus();
        mostrarDiv('error_fecha_real');
        return false;
    }
    if(convertirFecha(fecha_r.value)<convertirFecha(fecha_v.value)){
        ocultarDiv('error_fecha_real');
        ocultarDiv('error_fecha_val');
    }
    
    if(archivo.value == '' && form!="frm_edit_estudio_campo"){
       mostrarDiv('error_soporte');
       return false; 
    }
    if(pri_nombre.value == ''){
      pri_nombre.focus();
       mostrarDiv('error_pri_nombre');
       return false; 
    }
    if(pri_apellido.value == ''){
       pri_apellido.focus();
       mostrarDiv('error_pri_apellido');
       return false; 
    }
    if(cargo.value == ''){
       cargo.focus();
       mostrarDiv('error_cargo');
       return false; 
    }
    if(!validarCelular(celular.value)){
       celular.focus();
       mostrarDiv('error_celular');
       return false; 
    }
    
    document.getElementById(form).action = accion;
    document.getElementById(form).submit();
}

function cancelar_estudio_campo(form, accion) {
    document.getElementById(form).action = accion;
    document.getElementById(form).submit();
}

function validarLetras(name) {
    if (/^("|^[a-zA-Z]+(\s*[a-zA-Z]*)*[a-zA-Z]+$|")*$/.test(name) ) {
        return true;
    } else {
        return false;
    }
}
