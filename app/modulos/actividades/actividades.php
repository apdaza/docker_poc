<?php
/**
* Sistema POC
*
*<ul>
* <li> MadeOpen <madeopensoftware.com></li>
* <li> Proyecto KBT </li>
*</ul>
*/

/**
* Modulo actividades
* maneja el modulo actividades en union con CActividad y CActividadData
*
* @see CActividad
* @see CActividadData
*
* @package  modulos
* @subpackage actividades
* @author Alejandro Daza
* @version 2019.02
* @copyright apdaza
*/

	//no permite el acceso directo
	defined('_VALID_PRY') or die('Restricted access');
	$actData = new CActividadData($db);
	$operador = $_REQUEST['operador'];
	$perfil = $du->getUserPerfil($id_usuario);
	$task	= $_REQUEST['task'];
	if(empty($task)) $task = 'list';

	switch($task){
		/**
		* la variable list, permite hacer la carga la página con la lista de objetos actividad según los parámetros de entrada
		*/
		case 'list':

			$estado 	= $_REQUEST['sel_estado'];
			$subsistema 		= $_REQUEST['sel_subsistema'];
			$palabra_clave 	= $_REQUEST['txt_palabra_clave'];

			$criterio='';
			if(isset($estado) && $estado!=-1 && $estado!=''){
				if($criterio==""){
					$criterio = " ace.ace_id = ".$estado;
				}else{
					$criterio .= " and ace.ace_id = ".$estado;
				}
			}
			if(isset($subsistema) && $subsistema!=-1 && $subsistema!=''){
				if($criterio==""){
					$criterio = " acs.acs_id = ".$subsistema;
				}else{
					$criterio .= " and acs.acs_id = ".$subsistema;
				}
			}
			if(isset($palabra_clave) && $palabra_clave!=''){
				if($criterio==""){
					$criterio = " (act.act_descripcion  like '%".$palabra_clave."%' || act.act_inconvenientes like '%".$palabra_clave."%' )";
				}else{
					$criterio .= " and (act.act_descripcion  like '%".$palabra_clave."%' || act.act_inconvenientes like '%".$palabra_clave."%')";
				}
			}
			$form = new CHtmlForm();
			$form->setId('frm_list');
			$form->setMethod('post');
			$form->setTitle(ACTIVIDAD_TITULO);
			$form->setClassEtiquetas('td_label');

			$estados = $actData->getEstados('1','ace_nombre');
			$opciones=null;
			foreach($estados as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(ACTIVIDAD_ESTADO);
			$form->addSelect('select','sel_estado','sel_estado',$opciones,ACTIVIDAD_ESTADO,$estado,'','onChange=submit();');

			$subsistemas = $actData->getSubsistemas('1','acs_nombre');

			$opciones=null;
			foreach($subsistemas as $t){
				$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
			}
			$form->addEtiqueta(ACTIVIDAD_SUBSISTEMA);
			$form->addSelect('select','sel_subsistema','sel_subsistema',$opciones,ACTIVIDAD_SUBSISTEMA,$subsistema,'','onChange=submit();');

			$form->addEtiqueta(ACTIVIDAD_CLAVE);
			$form->addInputText('text','txt_palabra_clave','txt_palabra_clave','50','50',$palabra_clave,'','onChange=submit();');

			//echo("<br>criterio:".$criterio);

			$form->writeForm();

			$actividades = $actData->getActividades($criterio,' act.act_descripcion');

			$dt = new CHtmlDataTable();
			$titulos = array(ACTIVIDAD_DESCRIPCION,ACTIVIDAD_FECHA_INICIO,ACTIVIDAD_FECHA_FIN,ACTIVIDAD_RESPONSABLE,ACTIVIDAD_ESTADO,ACTIVIDAD_INCONVENIENTES,ACTIVIDAD_SUBSISTEMA);
			$dt->setDataRows($actividades);
			$dt->setTitleRow($titulos);

			$dt->setTitleTable(ACTIVIDAD_TITULO);

			//if($perfil==PERFIL_ADMIN || $perfil==PERFIL_ANALISTA || $perfil==PERFIL_ANALISTA_SENIOR){
				$dt->setEditLink("?mod=".$modulo."&niv=".$niv."&task=edit&sel_estado=".$estado."&sel_subsistema=".$subsistema."&operador=".$operador);
				$dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=delete&sel_estado=".$estado."&sel_subsistema=".$subsistema."&operador=".$operador);

				$dt->setAddLink("?mod=".$modulo."&niv=".$niv."&task=add&sel_estado=".$estado."&sel_subsistema=".$subsistema."&operador=".$operador);
			//}
			//otros links------------------------------------------------------------------------
			$otros = array('link'=>"?mod=".$modulo."&niv=".$niv."&task=listSoportes&sel_estado=".$estado."&sel_subsistema=".$subsistema."&operador=".$operador,'img'=>'soportes.gif','alt'=>ALT_SOPORTES);
			$dt->addOtrosLink($otros);
			$otros = array('link'=>"?mod=".$modulo."&niv=".$niv."&task=listObligaciones&sel_estado=".$estado."&sel_subsistema=".$subsistema."&operador=".$operador,'img'=>'obligaciones.png','alt'=>ALT_OBLIGACIONES);
			$dt->addOtrosLink($otros);
			//------------------------------------------------------------------------------------

			$dt->setType(1);
			$pag_crit="?mod=".$modulo."&niv=".$niv."&sel_estado=".$estado."&sel_subsistema=".$subsistema."&operador=".$operador;
			$dt->setPag(1,$pag_crit);
			$dt->writeDataTable($niv);
			$tabla = new CHtmlTable();

		break;
		/**
		* la variable add, permite hacer la carga la página con las variables que componen el objeto OBLIGACION, ver la clase CObligacion
		*/
		case 'add':
			$estado 	= $_REQUEST['sel_estado'];
			$subsistema 		= $_REQUEST['sel_subsistema'];
			$operador		= $_REQUEST['operador'];

			$estado_add	= $_REQUEST['sel_estado_add'];
			$subsistema_add 	= $_REQUEST['sel_subsistema_add'];

			$form = new CHtmlForm();
			$form->setTitle(AGREGAR_ACTIVIDAD);
			$form->setId('frm_add_actividad');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$estados = $actData->getEstados('1','ace_nombre');
			$opciones=null;
			foreach($estados as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(ACTIVIDAD_ESTADO);
			$form->addSelect('select','sel_estado_add','sel_estado_add',$opciones,ACTIVIDAD_ESTADO,$estado_add,'','onkeypress="ocultarDiv(\'error_estado\');"');
			$form->addError('error_estado',ERROR_ACTIVIDAD_ESTADO);

			$subsistemas = $actData->getSubsistemas('1','acs_nombre');

			$opciones=null;
			foreach($subsistemas as $t){
				$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
			}
			$form->addEtiqueta(ACTIVIDAD_SUBSISTEMA);
			$form->addSelect('select','sel_subsistema_add','sel_subsistema_add',$opciones,ACTIVIDAD_SUBSISTEMA,$subsistema_add,'','onkeypress="ocultarDiv(\'error_subsistema\');"');
			$form->addError('error_subsistema',ERROR_ACTIVIDAD_SUBSISTEMA);

			$form->addEtiqueta(ACTIVIDAD_DESCRIPCION);
			$form->addTextArea('textarea','txt_descripcion_add','txt_descripcion_add','65','5',$descripcion_add,'','onkeypress="ocultarDiv(\'error_descripcion\');"');
			$form->addError('error_descripcion',ERROR_ACTIVIDAD_DESCRIPCION);

			$form->addEtiqueta(ACTIVIDAD_FECHA_INICIO);
			$form->addInputDate('date','txt_fecha_inicio_add','txt_fecha_inicio_add',$fecha_inicio_add,'%Y-%m-%d','16','16','','');
			$form->addError('error_fecha_inicio',ERROR_ACTIVIDAD_FECHA_INICIO);

			$form->addEtiqueta(ACTIVIDAD_FECHA_FIN);
			$form->addInputDate('date','txt_fecha_fin_add','txt_fecha_fin_add',$fecha_fin_add,'%Y-%m-%d','16','16','','');
			$form->addError('error_fecha_fin',ERROR_ACTIVIDAD_FECHA_FIN);

			$form->addEtiqueta(ACTIVIDAD_INCONVENIENTES);
			$form->addTextArea('textarea','txt_inconvenientes_add','txt_inconvenientes_add','65','5',$inconvenientes_add,'','onkeypress="ocultarDiv(\'error_inconvenientes\');"');
			$form->addError('error_inconvenientes',ERROR_ACTIVIDAD_INCONVENIENTES);

			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','sel_subsistema','sel_subsistema','15','15',$subsistema,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');

			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_actividad();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_add_actividad\',\'?mod='.$modulo.'&niv='.$niv.'&sel_estado='.$estado.'&sel_subsistema='.$subsistema.'&operador='.$operador.'\');"');

			$form->writeForm();

		break;
		/**
		* la variable saveAdd, permite almacenar el objeto actividad en la base de datos, ver la clase CActividadData
		*/
		case 'saveAdd':
			$estado = $_REQUEST['sel_estado'];
			$subsistema	= $_REQUEST['sel_subsistema'];
			$operador	= $_REQUEST['operador'];

			$estado_add = $_REQUEST['sel_estado_add'];
			$subsistema_add	= $_REQUEST['sel_subsistema_add'];
			$inconvenientes_add	= $_REQUEST['txt_inconvenientes_add'];
			$descripcion_add = $_REQUEST['txt_descripcion_add'];
			$fecha_inicio_add = $_REQUEST['txt_fecha_inicio_add'];
			$fecha_fin_add = $_REQUEST['txt_fecha_fin_add'];

			$actividades = new CActividad('',$descripcion_add,$fecha_inicio_add,$fecha_fin_add,$id_usuario,$estado_add,$inconvenientes_add,$subsistema_add,$actData);
			$m = $actividades->saveNewActidad();

			echo $html->generaAviso($m,"?mod=".$modulo."&niv=1&task=list&sel_estado=".$estado."&sel_subsistema=".$subsistema."&operador=".$operador);

		break;
		/**
		* la variable delete, permite hacer la carga del objeto OBLIGACION y espera confirmacion de eliminarlo, ver la clase CObligacion
		*/
		case 'delete':
			$id_delete = $_REQUEST['id_element'];
			$estado = $_REQUEST['sel_estado'];
			$subsistema	= $_REQUEST['sel_subsistema'];
			$operador	= $_REQUEST['operador'];

			$form = new CHtmlForm();
			$form->setId('frm_delete');
			$form->setMethod('post');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','sel_subsistema','sel_subsistema','15','15',$subsistema,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			$form->writeForm();

			echo $html->generaAdvertencia(ACTIVIDAD_MSG_BORRADO,'?mod='.$modulo.'&niv=1&task=confirmDelete&id_element='.$id_delete.'&sel_estado='.$estado.'&sel_subsistema='.$subsistema.'&operador='.$operador,"cancelarAccion('frm_delete','?mod=".$modulo."&niv=1&sel_estado=".$estado."&sel_subsistema=".$subsistema."&operador=".$operador."')");

		break;
		/**
		* la variable confirmDelete, permite eliminar el objeto OBLIGACION de la base de datos, ver la clase CObligacionInterventoriaData
		*/
		case 'confirmDelete':
			$id_delete 		= $_REQUEST['id_element'];
			$estado = $_REQUEST['sel_estado'];
			$subsistema	= $_REQUEST['sel_subsistema'];
			$operador	= $_REQUEST['operador'];

			$actividades = new CActividad($id_delete,'','','','','','','',$actData);
			$m = $actividades->deleteActividad();

			echo $html->generaAviso($m,'?mod='.$modulo.'&niv=1&task=list&sel_estado='.$estado.'&sel_subsistema='.$subsistema.'&operador='.$operador);

		break;
		/**
		* la variable edit, permite hacer la carga del objeto OBLIGACION y espera confirmacion de edicion, ver la clase CObligacion
		*/
		case 'edit':
			$id_edit 		= $_REQUEST['id_element'];
			$estado = $_REQUEST['sel_estado'];
			$subsistema	= $_REQUEST['sel_subsistema'];
			$operador	= $_REQUEST['operador'];

			$estado_edit = $_REQUEST['sel_estado_edit'];
			$subsistema_edit	= $_REQUEST['sel_subsistema_edit'];
			$inconvenientes_edit	= $_REQUEST['txt_inconvenientes_edit'];
			$descripcion_edit = $_REQUEST['txt_descripcion_edit'];
			$fecha_inicio_edit = $_REQUEST['txt_fecha_inicio_edit'];
			$fecha_fin_edit = $_REQUEST['txt_fecha_fin_edit'];


			$actividades = new CActividad($id_edit,'','','','','','','',$actData);

			$actividades->loadActividad();

			if(!isset($_REQUEST['sel_estado_edit']) || $estado_edit==-1)  $estado_edit  = $actividades->getEstado();  else $estado_edit  = $_REQUEST['sel_estado_edit'];
			if(!isset($_REQUEST['sel_subsistema_edit']) || $subsistema_edit==-1) $subsistema_edit = $actividades->getSubsistema(); else $subsistema_edit    = $_REQUEST['sel_subsistema_edit'];
			if(!isset($_REQUEST['txt_inconvenientes_edit'])  || $inconvenientes_edit=="")     $inconvenientes_edit = $actividades->getInconvenientes();     else $inconvenientes_edit = $_REQUEST['txt_inconvenientes_edit'];
			if(!isset($_REQUEST['txt_descripcion_edit']) || $descripcion_edit=="") $descripcion_edit = $actividades->getDescripcion(); else $descripcion_edit = $_REQUEST['txt_descripcion_edit'];
			if(!isset($_REQUEST['txt_fecha_inicio_edit']) || $fecha_inicio_edit=="") $fecha_inicio_edit = $actividades->getFechaInicio(); else $fecha_inicio_edit = $_REQUEST['txt_fecha_inicio_edit'];
			if(!isset($_REQUEST['txt_fecha_fin_edit']) || $fecha_fin_edit=="") $fecha_fin_edit = $actividades->getFechaFin(); else $fecha_fin_edit = $_REQUEST['txt_fecha_fin_edit'];

			$form = new CHtmlForm();

			$form->setTitle(EDITAR_ACTIVIDAD);
			$form->setId('frm_edit_actividad');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$estados = $actData->getEstados('1','ace_nombre');
			$opciones=null;
			foreach($estados as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}

			$form->addEtiqueta(ACTIVIDAD_ESTADO);
			$form->addSelect('select','sel_estado_edit','sel_estado_edit',$opciones,ACTIVIDAD_ESTADO,$estado_edit,'','onkeypress="ocultarDiv(\'error_estado\');"');
			$form->addError('error_estado',ERROR_ACTIVIDAD_ESTADO);

			$subsistemas = $actData->getSubsistemas('1','acs_nombre');
			$opciones=null;
			foreach($subsistemas as $t){
				$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
			}
			$form->addEtiqueta(ACTIVIDAD_SUBSISTEMA);
			$form->addSelect('select','sel_subsistema_edit','sel_subsistema_edit',$opciones,ACTIVIDAD_SUBSISTEMA,$subsistema_edit,'','onkeypress="ocultarDiv(\'error_subsistema\');"');
			$form->addError('error_subsistema',ERROR_ACTIVIDAD_SUBSISTEMA);

			$form->addEtiqueta(ACTIVIDAD_DESCRIPCION);
			$form->addTextArea('textarea','txt_descripcion_edit','txt_descripcion_edit','65','5',$descripcion_edit,'','onkeypress="ocultarDiv(\'error_descripcion\');"');
			$form->addError('error_descripcion',ERROR_ACTIVIDAD_DESCRIPCION);

			$form->addEtiqueta(ACTIVIDAD_FECHA_INICIO);
			$form->addInputDate('date','txt_fecha_inicio_edit','txt_fecha_inicio_edit',$fecha_inicio_edit,'%Y-%m-%d','16','16','','');
			$form->addError('error_fecha_inicio',ERROR_ACTIVIDAD_FECHA_INICIO);

			$form->addEtiqueta(ACTIVIDAD_FECHA_FIN);
			$form->addInputDate('date','txt_fecha_fin_edit','txt_fecha_fin_edit',$fecha_fin_edit,'%Y-%m-%d','16','16','','');
			$form->addError('error_fecha_fin',ERROR_ACTIVIDAD_FECHA_FIN);

			$form->addEtiqueta(ACTIVIDAD_INCONVENIENTES);
			$form->addTextArea('textarea','txt_inconvenientes_edit','txt_inconvenientes_edit','65','5',$inconvenientes_edit,'','onkeypress="ocultarDiv(\'error_inconvenientes\');"');
			$form->addError('error_inconvenientes',ERROR_ACTIVIDAD_INCONVENIENTES);


			$form->addInputText('hidden','id_element','id_element','15','15',$id_edit,'','');
			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','sel_subsistema','sel_subsistema','15','15',$subsistema,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');

			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_edit_actividad();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_edit_actividad\',\'?mod='.$modulo.'&niv='.$niv.'&sel_estado='.$estado.'&sel_subsistema='.$subsistema.'&operador='.$operador.'\');"');

			$form->writeForm();

		break;
		/**
		* la variable saveEdit, permite actualizar el objeto OBLIGACION en la base de datos, ver la clase CObligacionInterventoriaData
		*/
		case 'saveEdit':
			$id_edit = $_REQUEST['id_element'];
			$estado = $_REQUEST['sel_estado'];
			$subsistema	= $_REQUEST['sel_subsistema'];
			$operador	= $_REQUEST['operador'];

			$estado_edit = $_REQUEST['sel_estado_edit'];
			$subsistema_edit	= $_REQUEST['sel_subsistema_edit'];
			$inconvenientes_edit	= $_REQUEST['txt_inconvenientes_edit'];
			$descripcion_edit = $_REQUEST['txt_descripcion_edit'];
			$fecha_inicio_edit = $_REQUEST['txt_fecha_inicio_edit'];
			$fecha_fin_edit = $_REQUEST['txt_fecha_fin_edit'];

			$actividades = new CActividad($id_edit,$descripcion_edit,$fecha_inicio_edit,$fecha_fin_edit,$id_usuario,$estado_edit,$inconvenientes_edit,$subsistema_edit,$actData);
			$m = $actividades->saveEditActividad();
			echo $html->generaAviso($m,'?mod='.$modulo.'&niv=1&task=list&sel_estado='.$estado.'&sel_subsistema='.$subsistema.'&operador='.$operador);

		break;

		case 'listSoportes':
			$id_elemnent = $_REQUEST['id_element'];
			$estado = $_REQUEST['sel_estado'];
			$subsistema	= $_REQUEST['sel_subsistema'];
			$operador	= $_REQUEST['operador'];

			$tipo_list = $_REQUEST['sel_tipo_list'];

			$form = new CHtmlForm();
			$form->setTitle(EDITAR_ACTIVIDAD_SOPORTES);
			$form->setId('frm_soportes');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$tipos = $actData->getTiposSoportes();
			$opciones=null;
			foreach($tipos as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}
			$form->addEtiqueta(ACTIVIDAD_TIPO_SOPORTE);
			$form->addSelect('select','sel_tipo_list','sel_tipo_list',$opciones,ACTIVIDAD_TIPO_SOPORTE,$tipo_list,'','onChange="submit();""');
			$form->addError('error_estado',ERROR_ACTIVIDAD_TIPO_SOPORTE);

			if($tipo_list==1){
			}
			if($tipo_list==2){
			}

			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','sel_subsistema','sel_subsistema','15','15',$subsistema,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');


			//$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_soporte_actividad();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_soportes\',\'?mod='.$modulo.'&niv='.$niv.'&sel_estado='.$estado.'&sel_subsistema='.$subsistema.'&operador='.$operador.'\');"');

			$form->writeForm();

		break;

		/**
		* la variable addSoportes, permite hacer la carga del objeto soportes documentales al objeto Actividad.
		*/
		case 'addSoportes':
			$id_elemnent = $_REQUEST['id_element'];
			$estado = $_REQUEST['sel_estado'];
			$subsistema	= $_REQUEST['sel_subsistema'];
			$operador	= $_REQUEST['operador'];

			$tipo_add = $_REQUEST['sel_tipo_add'];

			$form = new CHtmlForm();
			$form->setTitle(EDITAR_ACTIVIDAD_SOPORTES);
			$form->setId('frm_soportes');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$tipos = $actData->getTiposSoportes();
			$opciones=null;
			foreach($tipos as $s){
				$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
			}
			$form->addEtiqueta(ACTIVIDAD_TIPO_SOPORTE);
			$form->addSelect('select','sel_tipo_add','sel_tipo_add',$opciones,ACTIVIDAD_TIPO_SOPORTE,$tipo_add,'','onChange="submit();""');
			$form->addError('error_estado',ERROR_ACTIVIDAD_TIPO_SOPORTE);

			if($tipo_add==1){
				$soportes = $actData->getComunicados('1','doc_archivo');
				$opciones=null;
				foreach($soportes as $s){
					$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
				}

				$form->addEtiqueta(ACTIVIDAD_SOPORTE);
				$form->addSelect('select','sel_soporte_add','sel_soporte_add',$opciones,ACTIVIDAD_SOPORTE,$soporte_add,'','onkeypress="ocultarDiv(\'error_soporte\');"');
				$form->addError('error_soporte',ERROR_ACTIVIDAD_SOPORTE);
			}
			if($tipo_add==2){
				$soportes = $actData->getDocumentos('1','doc_archivo');
				$opciones=null;
				foreach($soportes as $s){
					$opciones[count($opciones)] = array('value'=>$s['id'],'texto'=>$s['nombre']);
				}

				$form->addEtiqueta(ACTIVIDAD_SOPORTE);
				$form->addSelect('select','sel_soporte_add','sel_soporte_add',$opciones,ACTIVIDAD_SOPORTE,$soporte_add,'','onkeypress="ocultarDiv(\'error_soporte\');"');
				$form->addError('error_soporte',ERROR_ACTIVIDAD_SOPORTE);
			}

			$form->addInputText('hidden','sel_estado','sel_estado','15','15',$estado,'','');
			$form->addInputText('hidden','sel_subsistema','sel_subsistema','15','15',$subsistema,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');


			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_soporte_actividad();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_soportes\',\'?mod='.$modulo.'&niv='.$niv.'&sel_estado='.$estado.'&sel_subsistema='.$subsistema.'&operador='.$operador.'\');"');

			$form->writeForm();
			//echo $html->generaAdvertencia(ACTIVIDAD_MSG_BORRADO,'?mod='.$modulo.'&niv=1&task=confirmDelete&id_element='.$id_delete.'&sel_estado='.$estado.'&sel_subsistema='.$subsistema.'&operador='.$operador,"cancelarAccion('frm_delete','?mod=".$modulo."&niv=1&sel_estado=".$estado."&sel_subsistema=".$subsistema."&operador=".$operador."')");

		break;

		/**
		* en caso de que la variable task no este definida carga la página en construcción
		*/
		default:
			include('templates/html/under.html');

		break;
	}
?>
