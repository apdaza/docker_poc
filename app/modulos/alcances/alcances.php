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
* Modulo Alcances
* maneja el modulo ALCANCES en union con CAlcance y CAlcanceData
*
* @see CAlcance
* @see CAlcanceData
*
* @package  modulos
* @subpackage alcances
* @author Redcom Ltda
* @version 2013.01.00
* @copyright Ministerio de Transporte
*/

	//no permite el acceso directo
	defined('_VALID_PRY') or die('Restricted access');
	$alcancesData 	= new CAlcanceData($db);
	$operador 		= $_REQUEST['operador'];
	$task 			= $_REQUEST['task'];
	if(empty($task)) $task = 'list';
	
	switch($task){
		/**
		* la variable list, permite hacer la carga la página con la lista de objetos ALCANCE según los parámetros de entrada
		*/
		case 'list':
			$form = new CHtmlForm();
			$form->setId('frm_list_alcances');
			$form->setMethod('post');
			$form->setTitle(ALCANCE_TITULO);
			$form->setClassEtiquetas('td_label');
			$form->addInputText('hidden','txt_id','txt_id','15','15','','','');
			$form->writeForm();
		
			$alcances = $alcancesData->getAlcances('a.ope_id='.$operador,' a.alc_nombre');		
			
			$dt = new CHtmlDataTable();
			$titulos = array(ALCANCE_NOMBRE,ALCANCE_FECHA_REGISTRO,ALCANCE_CONTRATANTE,ALCANCE_CONTRATISTA,ALCANCE_INTERVENTORIA,ALCANCE_REUNION,ALCANCE_ESTADO);
			$dt->setDataRows($alcances);
			$dt->setTitleRow($titulos);
				
			$dt->setTitleTable(ALCANCE_SUBTITULO);
			
			$dt->setSeeLink("?mod=".$modulo."&niv=".$niv."&task=see&operador=".$operador);
			$dt->setEditLink("?mod=".$modulo."&niv=".$niv."&task=edit&operador=".$operador);
			$dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=delete&operador=".$operador);	
			
			$dt->setAddLink("?mod=".$modulo."&niv=".$niv."&task=add&operador=".$operador);	
				
			$dt->setType(1);
			$pag_crit="?mod=".$modulo."&niv=".$niv;
			$dt->setPag(1,$pag_crit);
			$dt->writeDataTable($niv);
			
		break;
		/**
		* la variable add, permite hacer la carga la página con las variables que componen el objeto ALCANCE, ver la clase CAlcance
		*/
		case 'add':
			$alcance 				 	= $_REQUEST['txt_alcance'];
			$fecha_registro 		 	= $_REQUEST['txt_fecha_registro'];
			$responsable_contratante 	= $_REQUEST['sel_responsable_contratante'];
			$responsable_contratista 	= $_REQUEST['sel_responsable_contratista'];
			$responsable_interventoria  = $_REQUEST['sel_responsable_interventoria'];
			$form = new CHtmlForm();
	
			$form->setTitle(AGREGAR_ALCANCE);
			$form->setId('frm_add_alcance');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');
			
			$form->addEtiqueta(ALCANCE_NOMBRE);
			$form->addInputText('text','txt_alcance','txt_alcance','100','100',$alcance,'','onkeypress="ocultarDiv(\'error_alcance\');"');
			$form->addError('error_alcance',ERROR_ALCANCE_NOMBRE);
			
			$form->addEtiqueta(ALCANCE_FECHA_REGISTRO);
			$form->addInputDate('date','txt_fecha_registro','txt_fecha_registro',$fecha_registro,'%Y-%m-%d','16','16','','');
			$form->addError('error_fecha_registro',ERROR_ALCANCE_FECHA_REGISTRO);
			
			$responsables = $alcancesData->getResponsables('=1 and da.ope_id='.$operador,'us.usu_nombre');
			$opciones=null;
			if(isset($responsables)){
				foreach($responsables as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(ALCANCE_CONTRATANTE);
			$form->addSelect('select','sel_responsable_contratante','sel_responsable_contratante',$opciones,ALCANCE_CONTRATANTE,$responsable_contratante,'','');
			$form->addError('error_responsable_contratante',ERROR_ALCANCE_CONTRATANTE);
			
			$responsables = $alcancesData->getResponsables('=2 and da.ope_id='.$operador,'us.usu_nombre');
			$opciones=null;
			if(isset($responsables)){
				foreach($responsables as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(ALCANCE_CONTRATISTA);
			$form->addSelect('select','sel_responsable_contratista','sel_responsable_contratista',$opciones,ALCANCE_CONTRATISTA,$responsable_contratista,'','');
			$form->addError('error_responsable_contratista',ERROR_ALCANCE_CONTRATISTA);
			
			$responsables = $alcancesData->getResponsables('=4 and da.ope_id='.$operador,'us.usu_nombre');
			$opciones=null;
			if(isset($responsables)){
				foreach($responsables as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}

			$form->addEtiqueta(ALCANCE_INTERVENTORIA);
			$form->addSelect('select','sel_responsable_interventoria','sel_responsable_interventoria',$opciones,ALCANCE_INTERVENTORIA,$responsable_interventoria,'','');
			$form->addError('error_responsable_interventoria',ERROR_ALCANCE_INTERVENTORIA);
			
			$form->addEtiqueta(ALCANCE_REUNION);
			$form->addInputText('text','txt_reunion','txt_reunion','100','100',$reunion,'','onkeypress="ocultarDiv(\'error_reunion\');"');
			$form->addError('error_reunion',ERROR_ALCANCE_REUNION);
			
			$estados = $alcancesData->getEstados('1','ale_nombre');
			$opciones=null;
			if(isset($estados)){
				foreach($estados as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(ALCANCE_ESTADO);
			$form->addSelect('select','sel_estado','sel_estado',$opciones,ALCANCE_ESTADO,$estado,'','');
			$form->addError('error_estado',ERROR_ALCANCE_ESTADO);
			
			$form->addEtiqueta(ALCANCE_OBSERVACIONES);
			$form->addTextArea('textarea','txt_observaciones','txt_observaciones','65','5',$observaciones,'','onkeypress="ocultarDiv(\'error_observaciones\');"');
			$form->addError('error_observaciones',ERROR_ALCANCE_OBSERVACIONES);

			$form->addEtiqueta(ALCANCE_REGISTRO);
			$form->addInputText('text','txt_registro','txt_registro','1','1',$registro,'','onkeypress="ocultarDiv(\'error_registro\');"');
			$form->addError('error_registro',ERROR_ALCANCE_REGISTRO);
			
			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_alcance1();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_add_alcance\',\'?mod='.$modulo.'&niv='.$niv.'&operador='.$operador.'\');"');
			
			$form->addInputText('hidden','txt_operador','txt_operador','15','15',$operador,'','');
			
			$form->writeForm();
			
		break;
		/**
		* la variable saveAdd, permite almacenar el objeto ALCANCE en la base de datos, ver la clase CAlcanceData
		*/
		case 'saveAdd':
			$alcance 				 	= $_REQUEST['txt_alcance'];
			$fecha_registro 		 	= $_REQUEST['txt_fecha_registro'];
			$responsable_contratante 	= $_REQUEST['sel_responsable_contratante'];
			$responsable_contratista 	= $_REQUEST['sel_responsable_contratista'];
			$responsable_interventoria 	= $_REQUEST['sel_responsable_interventoria'];
			$reunion 	 			 	= $_REQUEST['txt_reunion'];
			$estado				 	 	= $_REQUEST['sel_estado'];
			$observaciones		 	 	= $_REQUEST['txt_observaciones'];
			$registro			 	 	= $_REQUEST['txt_registro'];
			$operador				 	= $_REQUEST['txt_operador'];
		
			$alcances = new CAlcance('',$alcance,$fecha_registro,$responsable_contratante,$responsable_contratista,$responsable_interventoria,$reunion,$estado,$observaciones,$registro,$operador,$alcancesData);
								
			$m = $alcances->saveNewAlcance();
			echo $html->generaAviso($m,"?mod=".$modulo."&niv=1&task=list&operador=".$operador);
			
		break;
		/**
		* la variable delete, permite hacer la carga del objeto ALCANCE y espera confirmacion de eliminarlo, ver la clase CAlcance
		*/
		case 'delete':
			$id_delete = $_REQUEST['id_element'];
			$operador  = $_REQUEST['operador'];
			$alcance = new CAlcance($id_delete,'','','','','','','','','','',$alcancesData);
						
			$form = new CHtmlForm();
			$form->setId('frm_delet');
			$form->setMethod('post');
			$form->addInputText('hidden','txt_id','txt_id','15','15',$alcance->getId(),'','');
			$form->writeForm();

			echo $html->generaAdvertencia(ALCANCE_MSG_BORRADO,'?mod='.$modulo.'&niv=1&task=confirmDelete&id_element='.$id_delete.'&sel_responsable='.$responsable.'&operador='.$operador,"cancelarAccion('frm_delet','?mod=".$modulo."&niv=1&sel_responsable=".$responsable."&operador=".$operador."')");
			
		break;
		/**
		* la variable confirmDelete, permite eliminar el objeto ALCANCE de la base de datos, ver la clase CAlcanceData
		*/
		case 'confirmDelete':
			$id_delete = $_REQUEST['id_element'];
			$operador= $_REQUEST['operador'];
			$alcance = new CAlcance($id_delete,'','','','','','','','','',$operador,$alcancesData);
			$m = $alcance->deleteAlcance();

			echo $html->generaAviso($m,'?mod='.$modulo.'&niv=1&task=list&sel_responsable='.$responsable.'&operador='.$operador);
			
		break;
		/**
		* la variable edit, permite hacer la carga del objeto ALCANCE y espera confirmacion de edicion, ver la clase CAlcance
		*/
		case 'edit':	
			$id_edit 				 	= $_REQUEST['id_element'];
			$alcance 				 	= $_REQUEST['txt_alcance'];
			$fecha_registro 		 	= $_REQUEST['txt_fecha_registro'];
			$responsable_contratante 	= $_REQUEST['sel_responsable_contratante'];
			$responsable_contratista 	= $_REQUEST['sel_responsable_contratista'];
			$responsable_interventoria 	= $_REQUEST['sel_responsable_interventoria'];
			$reunion 				 	= $_REQUEST['txt_reunion'];
			$estado				 	 	= $_REQUEST['sel_estado'];
			$observaciones		 	 	= $_REQUEST['txt_observaciones'];
			$registro			 	 	= $_REQUEST['txt_registro'];
			$operador		         	= $_REQUEST['operador'];
			
			$alcances = new CAlcance($id_edit,'','','','','','','','','','',$alcancesData);
			$alcances->loadAlcance();
			
			if($alcance == '' || $_REQUEST['txt_alcance'] == '') 									$alcance 					= $alcances->getNombre(); else $alcance = $_REQUEST['txt_alcance'];
			if($fecha_registro==-1 ||  $_REQUEST['txt_fecha_registro'] == '') 						$fecha_registro 			= $alcances->getFechaRegistro(); else $fecha_registro = $_REQUEST['txt_fecha_registro'];
			if($responsable_contratante==-1 || $_REQUEST['sel_responsable_contratante'] == '') 		$responsable_contratante 	= $alcances->getResponsableContratante(); else $responsable_contratante = $_REQUEST['sel_responsable_contratante'];
			if($responsable_contratista==-1 || $_REQUEST['sel_responsable_contratista'] == '') 		$responsable_contratista 	= $alcances->getResponsableContratista(); else $responsable_contratista = $_REQUEST['sel_responsable_contratista'];
			if($responsable_interventoria==-1 || $_REQUEST['sel_responsable_interventoria'] == '')  $responsable_interventoria  = $alcances->getResponsableinterventoria();     else $responsable_interventoria       = $_REQUEST['sel_responsable_interventoria'];
			if($estado==-1 ||  $_REQUEST['sel_estado'] == '') 										$estado 					= $alcances->getEstado(); else $estado = $_REQUEST['sel_estado'];
			if($observaciones=='' ||  $_REQUEST['txt_observaciones'] == '') 						$observaciones 				= $alcances->getObservaciones(); else $observaciones = $_REQUEST['txt_observaciones'];
			if($registro=='' ||  $_REQUEST['txt_registro'] == '') 									$registro 					= $alcances->getRegistro(); else $registro = $_REQUEST['txt_registro'];
			if($reunion == '' || $_REQUEST['txt_reunion'] == '') 									$reunion 					= $alcances->getReunion(); else $reunion = $_REQUEST['txt_reunion'];
						
			$form = new CHtmlForm();
	
			$form->setTitle(EDITAR_ALCANCE);
			$form->setId('frm_edit_alcance');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');
			
			$form->addInputText('hidden','txt_id','txt_id','15','15',$alcances->getId(),'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');

			$form->addEtiqueta(ALCANCE_NOMBRE);
			$form->addInputText('text','txt_alcance','txt_alcance','100','100',$alcance,'','onkeypress="ocultarDiv(\'error_alcance\');"');
			$form->addError('error_alcance',ERROR_ALCANCE_NOMBRE);
			
			$form->addEtiqueta(ALCANCE_FECHA_REGISTRO);
			$form->addInputDate('date','txt_fecha_registro','txt_fecha_registro',$fecha_registro,'%Y-%m-%d','16','16','','');
			$form->addError('error_fecha_registro',ERROR_ALCANCE_FECHA_REGISTRO);
			
			$responsables = $alcancesData->getResponsables('=1 and da.ope_id='.$operador,'us.usu_nombre');
			$opciones=null;
			if(isset($responsables)){
				foreach($responsables as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(ALCANCE_CONTRATANTE);
			$form->addSelect('select','sel_responsable_contratante','sel_responsable_contratante',$opciones,ALCANCE_CONTRATANTE,$responsable_contratante,'','');
			$form->addError('error_responsable_contratante',ERROR_ALCANCE_CONTRATANTE);
			
			$responsables = $alcancesData->getResponsables('=2 and da.ope_id='.$operador,'us.usu_nombre');
			$opciones=null;
			if(isset($responsables)){
				foreach($responsables as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(ALCANCE_CONTRATISTA);
			$form->addSelect('select','sel_responsable_contratista','sel_responsable_contratista',$opciones,ALCANCE_CONTRATISTA,$responsable_contratista,'','');
			$form->addError('error_responsable_contratista',ERROR_ALCANCE_CONTRATISTA);
			
			$responsables = $alcancesData->getResponsables('> 0 and da.ope_id='.$operador,'us.usu_nombre');
			$opciones=null;
			if(isset($responsables)){
				foreach($responsables as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			
			$form->addEtiqueta(ALCANCE_INTERVENTORIA);
			$form->addSelect('select','sel_responsable_interventoria','sel_responsable_interventoria',$opciones,ALCANCE_INTERVENTORIA,$responsable_interventoria,'','');
			$form->addError('error_responsable_interventoria',ERROR_ALCANCE_INTERVENTORIA);
			
			$form->addEtiqueta(ALCANCE_REUNION);
			$form->addInputText('text','txt_reunion','txt_reunion','100','100',$reunion,'','onkeypress="ocultarDiv(\'error_reunion\');"');
			$form->addError('error_reunion',ERROR_ALCANCE_REUNION);
			
			$estados = $alcancesData->getEstados('1','ale_nombre');
			$opciones=null;
			if(isset($estados)){
				foreach($estados as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(ALCANCE_ESTADO);
			$form->addSelect('select','sel_estado','sel_estado',$opciones,ALCANCE_ESTADO,$estado,'','');
			$form->addError('error_estado',ERROR_ALCANCE_ESTADO);

			$form->addEtiqueta(ALCANCE_OBSERVACIONES);
			$form->addTextArea('textarea','txt_observaciones','txt_observaciones','65','5',$observaciones,'','onkeypress="ocultarDiv(\'error_observaciones\');"');
			$form->addError('error_observaciones',ERROR_ALCANCE_OBSERVACIONES);

			$form->addEtiqueta(ALCANCE_REGISTRO);
			$form->addInputText('text','txt_registro','txt_registro','1','1',$registro,'','onkeypress="ocultarDiv(\'error_registro\');"');
			$form->addError('error_registro',ERROR_ALCANCE_REGISTRO);
			
			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_edit_alcance1();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_edit_alcance\',\'?mod='.$modulo.'&niv='.$niv.'&sel_responsable='.$responsable.'&operador='.$operador.'\');"');
			
			$form->writeForm();
			
		break;
		/**
		* la variable saveEdit, permite actualizar el objeto ALCANCE en la base de datos, ver la clase CAlcanceData
		*/
		case 'saveEdit':
			$id_edit = $_REQUEST['txt_id'];
			$alcance 				 	= $_REQUEST['txt_alcance'];
			$fecha_registro 		 	= $_REQUEST['txt_fecha_registro'];
			$responsable_contratante 	= $_REQUEST['sel_responsable_contratante'];
			$responsable_contratista 	= $_REQUEST['sel_responsable_contratista'];
			$responsable_interventoria 	= $_REQUEST['sel_responsable_interventoria'];
			$reunion 				 	= $_REQUEST['txt_reunion'];
			$estado				 	 	= $_REQUEST['sel_estado'];
			$observaciones		 	 	= $_REQUEST['txt_observaciones'];
			$registro			 	 	= $_REQUEST['txt_registro'];
			$operador		 	 		= $_REQUEST['operador'];
			
			$alcances = new CAlcance($id_edit,$alcance,$fecha_registro,$responsable_contratante,$responsable_contratista,$responsable_interventoria,$reunion,$estado,$observaciones,$registro,$operador,$alcancesData);
			$m = $alcances->saveEditAlcance();

			echo $html->generaAviso($m,'?mod='.$modulo.'&niv=1&task=list&sel_responsable='.$responsable.'&operador='.$operador);
			
		break;
		/**
		* la variable see, permite hacer la carga del objeto ALCANCE para ver sus variables, ver la clase CAlcance
		*/
		case 'see':
			$id_edit = $_REQUEST['id_element'];
			$operador = $_REQUEST['operador'];
			
			$alcance = new CAlcance($id_edit,'','','','','','','','','','',$alcancesData);
			$alcance->loadSeeAlcance();
			
			$dt = new CHtmlDataTable();
			$titulos = array(ALCANCE_NOMBRE,ALCANCE_FECHA_REGISTRO,
								ALCANCE_CONTRATANTE,
								ALCANCE_CONTRATISTA,
								ALCANCE_INTERVENTORIA,
								ALCANCE_REUNION,ALCANCE_ESTADO,ALCANCE_OBSERVACIONES,ALCANCE_REGISTRO);
			$row_opcion = array($alcance->getNombre(),$alcance->getFechaRegistro(),
								$alcance->getResponsableContratante(),
								$alcance->getResponsableContratista(),
								$alcance->getResponsableInterventoria(),
								$alcance->getReunion(),$alcance->getEstado(),$alcance->getObservaciones(),$alcance->getRegistro());
			
			$dt->setDataRows($row_opcion);
			$dt->setTitleRow($titulos);
			
			$dt->setTitleTable(VER_ALCANCE);
			
			$dt->setType(2);
			
			$dt->writeDataTable($niv);
			echo $html->generaScriptLink("cancelarAccion('frm_see','?mod=".$modulo."&niv=".$niv."&sel_responsable=".$responsable."&operador=".$operador."')");
			
			$form = new CHtmlForm();
			$form->setId('frm_see');
			$form->setMethod('post');
			$form->addInputText('hidden','txt_id','txt_id','15','15',$alcance->getId(),'','');
			$form->writeForm();
			
		break;	
		/**
		* en caso de que la variable task no este definida carga la página en construcción
		*/
		default:
			include('templates/html/under.html'); 
		
		break;
	}
?>