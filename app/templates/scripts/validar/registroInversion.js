/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function consultar_registro_inversion() {
    document.getElementById('frm_list_registro_inversion').action = '?mod=registroInversion&niv=1';
    document.getElementById('frm_list_registro_inversion').submit();
}
function exportar_excel_registro_inversion() {
    document.getElementById('frm_list_registro_inversion').action = 'modulos/interventoria/registroInversion_en_excel.php';
    document.getElementById('frm_list_registro_inversion').submit();
}