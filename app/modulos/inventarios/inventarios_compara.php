<?php
/**
*Gestion Interventoria - Fenix
*
*<ul>
*<li> Redcom Ltda <www.redcom.com.co></li>
*<li> Proyecto RUNT</li>
*</ul>
*/

/**
* Modulo VisitaCompara
* maneja el modulo VISITA_COMPARAS en union con CIngresoCompara y CInvolucradoInventarioComparaData
*
* @see CInvolucradoInventarioCompara
* @see CInvolucradoInventarioComparaData
*
* @package  modulos
* @subpackage tramites
* @author Redcom Ltda
* @version 2013.01.00
* @copyright Ministerio de Transporte
*/

	//no permite el acceso directo
	defined('_VALID_PRY') or die('Restricted access');
	$invData 		= new CInvolucradoInventarioComparaData($db);
	$operador 		= $_REQUEST['operador'];
	$task 			= $_REQUEST['task'];
	if(empty($task)) $task = 'list';

	switch($task){
		/**
		* la variable list, permite hacer la carga de la página con la lista de objetos VISITA_COMPARA según los parámetros de entrada
		*/
		case 'list':
			if(isset($_REQUEST['txt_fecha_ini'])){
				$fecha_inicio = $_REQUEST['txt_fecha_ini'];
			}else{
				$fecha_inicio = "";
			}
			if(isset($_REQUEST['txt_fecha_fin'])){
				$fecha_fin = $_REQUEST['txt_fecha_fin'];
			}else{
				$fecha_fin = "";
			}
			$form = new CHtmlForm();
			$form->setId('frm_list_equipos');
			$form->setMethod('post');
			$form->setTitle('CUADRO DE CONTROL DE INVENTARIOS');
			$form->setClassEtiquetas('td_label');
			
						
			$form->addEtiqueta('Fecha de corte inicial');
			$form->addInputDate('date','txt_fecha_ini','txt_fecha_ini',$fecha_inicio,'%Y-%m-%d','16','16','','');
			
			$form->addEtiqueta('Fecha de corte final');
			$form->addInputDate('date','txt_fecha_fin','txt_fecha_fin',$fecha_fin,'%Y-%m-%d','16','16','','onChange=submit();');
			$form->writeForm();
			
			$equipos = $invData->getInventariosReposicion($operador,$fecha_inicio,$fecha_fin);		
			
			$dt = new CHtmlDataTableCorta();
			$titulos = array(INVOLUCRADOS_TIPO,INVOLUCRADOS_NOMBRE,INVENTARIO_EQUIPO,INVENTARIO_FECHA_COMPRA, 'Fecha de reposición',INVENTARIO_ESTADO);
			$dt->setDataRows($equipos);
			$dt->setTitleRow($titulos);
				
			$dt->setTitleTable('CONTROL DE INVENTARIOS - PROXIMA REPOSICION');
			
				
			$form->addInputText('hidden','txt_id','txt_id','15','15','','','');
			
			$dt->setType(1);
			$pag_crit="?mod=".$modulo."&niv=".$niv."&operador=".$operador."&txt_fecha_inicio=".$fecha_inicio;
			$dt->setPag(1,$pag_crit);
			$dt->writeDataTable($niv);
			
		break;
		/**
		* en caso de que la variable task no este definida carga la página en construcción
		*/
		default:
			include('templates/html/under.html'); 
		
		break;
	}
?>