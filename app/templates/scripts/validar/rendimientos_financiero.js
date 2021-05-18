function validar_add_remdimiento(form){
    if(document.getElementById('sel_cuenta').value == '-1'){
       mostrarDiv('error_cuenta');
       return false; 
    }
    if(document.getElementById('txt_mes').value == "" || 
       document.getElementById('txt_mes').value == "0000-00-00" ){
       mostrarDiv('error_mes');
       return false;
    }
    if(document.getElementById('txt_anio').value == "" || 
       document.getElementById('txt_anio').value == "0000-00-00" ){
       mostrarDiv('error_anio');
       return false;
    }
        
    if(document.getElementById('txt_rendimiento_financiero').value == "" ||
       !validarReal(document.getElementById('txt_rendimiento_financiero').value)){
       mostrarDiv('error_rendimiento_financiero');
       return false;
    }
    
    if(document.getElementById('txt_descuentos').value == "" ||
       !validarReal(document.getElementById('txt_descuentos').value)){
       mostrarDiv('error_descuentos');
       return false;
    }
    
    if(document.getElementById('txt_rendimiento_consignado').value == "" ||
       !validarReal(document.getElementById('txt_rendimiento_consignado').value)){
       mostrarDiv('error_rendimiento_consignado');
       return false;
    }

    if(document.getElementById('txt_rendimiento_acumulado').value == "" ||
       !validarReal(document.getElementById('txt_rendimiento_acumulado').value)){
       mostrarDiv('error_rendimiento_acumulado');
       return false;
    }

    if(document.getElementById('txt_rentabilidad_tasa').value == "" ||
       !validarReal(document.getElementById('txt_rentabilidad_tasa').value)){
       mostrarDiv('error_rentabilidad_tasa');
       return false;
    }
     
    if(document.getElementById('txt_fecha_consignacion').value == "" || 
       document.getElementById('txt_fecha_consignacion').value == "0000-00-00" ){
       mostrarDiv('error_fecha_consignacion');
       return false;
    }

    if(document.getElementById('file_comprobante_consignacion').value == ""){
       mostrarDiv('error_comprobante_consignacion');
       return false;  
    }
    
    if(document.getElementById('file_comprobante_emision').value == ""){
       mostrarDiv('error_comprobante_emision');
       return false;  
    }

    if(document.getElementById('sel_estado').value == '-1'){
       mostrarDiv('error_estado');
       return false; 
    }
    
    if(document.getElementById('txt_observaciones').value == ""){
       mostrarDiv('error_observaciones');
       return false;  
    }
        
    document.getElementById(form).action='?mod=rendimientos&niv=1&task=saveAdd';
    document.getElementById(form).submit();
}

function validar_edit_rendimientos(form){
   
    unformatNumber('txt_descuentos');
    if(document.getElementById('txt_descuentos').value == "" ||
       !validarReal(document.getElementById('txt_descuentos').value)){
       mostrarDiv('error_descuentos');
       return false;
    }
    formatNumber('txt_descuentos');
     
    if(document.getElementById('txt_fecha_consignacion').value == "" || 
       document.getElementById('txt_fecha_consignacion').value == "0000-00-00" ){
       mostrarDiv('error_fecha_consignacion');
       return false;
    }

    if(document.getElementById('file_comprobante_consignacion').value == ""){
       mostrarDiv('error_comprobante_consignacion');
       return false;  
    }
    
    if(document.getElementById('file_comprobante_emision').value == ""){
       mostrarDiv('error_comprobante_emision');
       return false;  
    }
    
    unformatNumber('txt_valor_fiduciaria');
     if(document.getElementById('txt_valor_fiduciaria').value == "" ||
       !validarReal(document.getElementById('txt_valor_fiduciaria').value)){
       mostrarDiv('error_valor_fiduciaria');
       return false;
    }
    formatNumber('txt_valor_fiduciaria');

    if(document.getElementById('sel_estado').value == '-1'){
       mostrarDiv('error_estado');
       return false; 
    }
    
    if(document.getElementById('txt_observaciones').value == ""){
       mostrarDiv('error_observaciones');
       return false;  
    }

     unformatNumber('txt_descuentos');
     unformatNumber('txt_valor_fiduciaria');
     
    document.getElementById(form).action='?mod=rendimientos&niv=1&task=saveEdit';
    document.getElementById(form).submit();
}