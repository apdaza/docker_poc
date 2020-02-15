function validarSaldos(saldop_contrato,saldop_amortizacion){
    var valor_factura = parseInt(replaceAll(document.getElementById('txt_valor_factura').value,'.',''));
    var amortizacion = parseInt(replaceAll(document.getElementById('txt_amortizacion').value,'.',''));
    if((valor_factura+amortizacion)>saldop_contrato ){
        alert('Los valores de la factura y la amortizaci\xf3n, superan el saldo del contrato = '+saldop_contrato);
        return false;
    }
    if((amortizacion)>saldop_amortizacion ){
        alert('El valor de la amortizaci\xf3n, supera el saldo de la amortizaci\xf3n = '+saldop_amortizacion);
        return false;
    }
}

function consultar_informe_financiero() {
    document.getElementById('frm_list_informe_financiero').action = '?mod=informeFinanciero&niv=1';
    document.getElementById('frm_list_informe_financiero').submit();
}
function exportar_excel_informe_financiero() {
    document.getElementById('frm_list_informe_financiero').action = 'modulos/interventoria/informeFinanciero_en_excel.php';
    document.getElementById('frm_list_informe_financiero').submit();
}
function agregarFechaPago(idTable,value) {
    if (document.getElementById('sel_estado').value === '2' && (!document.getElementById('11') || value!=='')) {
        var table = document.getElementById(idTable);
        var lastPosition = table.rows.length - 2;
        var row = table.insertRow(lastPosition);
        var cell = row.insertCell(0);
        cell.innerHTML = 'Fecha de Pago';
        cell = row.insertCell(1);
        cell.innerHTML = "<label id='11' ></label><input type='text>'"
                + " id='txt_fecha_pago'"
                + " name = 'txt_fecha_pago'"
                + " size='16' value='"+value+"' maxlength='16'  title='Ingrese una fecha en el formato AAAA-MM-DD' required='' onclick='limpiar('txt_fecha_pago')'>"
                + " <img src='templates/img/date.gif' border='0'"
                + " width='20' id='boton_txt_fecha_pago' style='cursor: pointer;"
                + " vertical-align:middle;' title='Date selector'>";
        cell.innerHTML + "<script type='text/javascript'>"
                + Calendar.setup({inputField: 'txt_fecha_pago', // id of the input field
                    ifFormat: '%Y-%m-%d', // format of the input field
                    showsTime: false, // will display a time selector
                    button: 'boton_txt_fecha_pago', // trigger for the calendar (button ID)
                    singleClick: true, // double-click mode
                    step: 1                				// show all years in drop-down boxes 
                });
        +"</script>";
        var input = 11;
        input.value = lastPosition;
    } else {
        if (document.getElementById('11')) {
            document.getElementById(idTable).deleteRow(10);
        }
    }
}