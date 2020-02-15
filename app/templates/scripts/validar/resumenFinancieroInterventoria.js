/**
 * Envia la orden de generar el archivo en la url 
 * @returns {undefined}
 */
function exportar_excel_ingresos_interventoria() {
    document.getElementById('frm_list_ingresos').action = 'modulos/interventoria/resumenFinancieroInterventoria_ingresos_excel.php';
    document.getElementById('frm_list_ingresos').submit();
}
function exportar_grafica_ingresos_interventoria() {
    document.getElementById('frm_list_ingresos').action = '?mod=resumenFinancieroInterventoria&niv=1&operador=1&task=GraficasIngresos';
    document.getElementById('frm_list_ingresos').submit();
}
function exportar_excel_ria_interventoria() {
    document.getElementById('frm_list_ingresos').action = 'modulos/interventoria/resumenFinancieroInterventoria_ria_excel.php';
    document.getElementById('frm_list_ingresos').submit();
}
function exportar_grafica_ria_interventoria() {
    document.getElementById('frm_list_ingresos').action = '?mod=resumenFinancieroInterventoria&niv=1&operador=1&task=GraficasRIA';
    document.getElementById('frm_list_ingresos').submit();
}
function exportar_excel_egresos_interventoria() {
    document.getElementById('frm_list_ingresos').action = 'modulos/interventoria/resumenFinancieroInterventoria_egresos_excel.php';
    document.getElementById('frm_list_ingresos').submit();
}
function exportar_grafica_egresos_interventoria() {
    document.getElementById('frm_list_ingresos').action = '?mod=resumenFinancieroInterventoria&niv=1&operador=1&task=GraficasEgresos';
    document.getElementById('frm_list_ingresos').submit();
} 
function exportar_excel_resumen_interventoria() {
    document.getElementById('frm_list_resumen_registros').action = 'modulos/interventoria/resumenInversionInterventoria_excel.php';
    document.getElementById('frm_list_resumen_registros').submit();
}