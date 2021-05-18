<?php
/**
* Sistema GPC
*
*<ul>
* <li> MadeOpen <madeopensoftware.com></li>
* <li> Proyecto KBT </li>
*</ul>
*/

/**
* Modulo Inventarios
* maneja el modulo inventarios en union con CInventario y CInventarioData
*
* @see CInventario
* @see CInventarioData
* @package  modulos
* @subpackage inventarios
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/

	//no permite el acceso directo
	defined('_VALID_PRY') or die('Restricted access');
	$iniData 		= new CInventarioData($db);
  $operador		= $_REQUEST['operador'];
	$task 			= $_REQUEST['task'];
	if(empty($task)) $task = 'list';

	switch($task){
		/**
		* la variable list, permite hacer la carga la página con la lista de objetos INVOLUCRADO según los parámetros de entrada
		*/
		case 'list':
			/*$tipo	= $_REQUEST['sel_tipo'];
			$operador	= $_REQUEST['operador'];

			if (isset($tipo) && $tipo!=-1 && $tipo!="") {
				if ($criterio == '') $criterio = " it.ivg_id = ".$tipo;
				else $criterio .= " and it.ivg_id = ".$tipo;
			}


			$form = new CHtmlForm();

			$form->setTitle(LISTAR_INVENTARIOS);
			$form->setId('frm_list_involucrado');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$tipos = $iniData->getGrupoInventario('1','ivg_nombre');
			$opciones=null;
			if(isset($tipos)){
				foreach($tipos as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(INVENTARIO_GRUPO);
			$form->addSelect('select','sel_tipo','sel_tipo',$opciones,INVENTARIO_GRUPO,$tipo,'','onChange=submit();');

			$form->writeForm();

			if ($criterio != ""){
				$criterio .= ' and o.ope_id = '.$operador;
				//echo("<br>criterio:".$criterio);
				$valores = $iniData->getGruposEquipos($criterio);
			}*/
			$valores = $iniData->getGruposEquipos($criterio);
			$dt = new CHtmlDataTable();
			$titulos = array(INVENTARIO_GRUPO,INVENTARIO_NRO_EQUIPOS);
			$dt->setDataRows($valores);
			$dt->setTitleRow($titulos);

			$dt->setTitleTable(TABLA_GRUPOS_INVENTARIO);

			$otros = array('link'=>"?mod=".$modulo."&niv=1&task=listEquipos&operador=".$operador,'img'=>'equipos.gif','alt'=>ALT_EQUIPOS);
			$dt->addOtrosLink($otros);

			$dt->setType(1);
			$pag_vait="task=list&sel_tipo=".$tipo."&sel_departamento=".$departamento."&sel_municipio=".$municipio."&operador=".$operador;
			$dt->setPag(1,$pag_vait);
			$dt->writeDataTable($niv);
		break;

		// **************************************************E Q U I P O S**************************************************************
		/**
		* la variable listEquipos, permite hacer la carga la página con la lista de objetos VISITA según los parámetros de entrada
		*/
		case 'listEquipos':
			$perfil = $du->getUserPerfil($id_usuario);
			$id_grupo = $_REQUEST['id_element'];

			//variables filtro cargadas en el list
			$tipo			= $_REQUEST['sel_tipo'];
			$departamento	= $_REQUEST['sel_departamento'];
			$municipio		= $_REQUEST['sel_municipio'];
			$operador   	= $_REQUEST['operador'];

			$inventario_equipos	= $iniData->getEquiposGrupo('ii.ivg_id='.$id_grupo);
			$grupo_nombre 	= $iniData->getGrupoNombreById($id_grupo);

			$dt = new CHtmlDataTable();
			$titulos = array(INVENTARIO_EQUIPO,INVENTARIO_MARCA,INVENTARIO_MODELO,INVENTARIO_SERIE,INVENTARIO_PLACA,INVENTARIO_FECHA_COMPRA,INVENTARIO_ESTADO,INVENTARIO_DESCRIPCION);

			$dt->setDataRows($inventario_equipos);
			$dt->setTitleRow($titulos);

			$dt->setTitleTable(TABLA_EQUIPOS."-".$grupo_nombre);
			//if($perfil==PERFIL_ADMIN || $perfil==PERFIL_ANALISTA){
				$dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=deleteEquipo&id_grupo=".$id_grupo."&operador=".$operador);
				$dt->setEditLink("?mod=".$modulo."&niv=".$niv."&task=editEquipo&id_grupo=".$id_grupo."&operador=".$operador);
				$dt->setAddLink("?mod=".$modulo."&niv=".$niv."&task=addEquipo&id_grupo=".$id_grupo."&operador=".$operador);
			//}
			/*$otros = array('link'=>"?mod=".$modulo."&niv=".$niv."&task=listSoportes&id_involucrado=".$id_involucrado."&sel_tipo=".$tipo."&sel_departamento=".$departamento."&sel_municipio=".$municipio."&operador=".$operador,'img'=>'soportes.gif','alt'=>ALT_VISITAS);
			$dt->addOtrosLink($otros);*/

			$dt->setType(1);
			$pag_vait="task=listEquipos&sel_tipo=".$tipo."&sel_departamento=".$departamento."&sel_municipio=".$municipio."&operador=".$operador;
			$dt->setPag(1,$pag_vait);

			$dt->writeDataTable($niv);
			$form = new CHtmlForm();
			$form->setId('frm_equipo_involucrado');
			$form->setMethod('post');

			//--------------------------------------
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			//-----------------------------------------

			$form->writeForm();
			$link = "?mod=".$modulo."&task=list&niv=".$niv."&id_grupo=".$id_grupo."&operador=".$operador;
			$html->generaLink($link,'cancelar.gif',BTN_CANCELAR);

		break;
		/**
		* la variable addEquipo, permite hacer la carga la página con las variables que componen el objeto VISITA, ver la clase CInvolucradoInventario
		*/
		case 'addEquipo':
			$id_grupo = $_REQUEST['id_grupo'];

			//variables filtro cargadas en el list
			$operador   	= $_REQUEST['operador'];

			$equipo			= $_REQUEST['sel_equipo'];
			$marca			= $_REQUEST['sel_marca'];
			$modelo			= $_REQUEST['txt_modelo'];
			$serie			= $_REQUEST['txt_serie'];
			$placa			= $_REQUEST['txt_placa'];
			$fecha_compra	= $_REQUEST['txt_fecha_compra'];
			$estado			= $_REQUEST['sel_estado'];
			$descripcion = $_REQUEST['txt_descripcion'];

			$grupo_nombre = $iniData->getGrupoNombreById($id_grupo);

			$form = new CHtmlForm();
			$form->setTitle(AGREGAR_EQUIPOS."-".$grupo_nombre);
			$form->setId('frm_add_involucrado_equipo');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$form->addInputText('hidden','id_grupo','id_grupo','15','15',$id_grupo,'','');

			$equipos = $iniData->getTipoEquipos('1','ine_nombre');
			$opciones=null;
			if(isset($equipos)){
				foreach($equipos as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(INVENTARIO_EQUIPO);
			$form->addSelect('select','sel_equipo','sel_equipo',$opciones,INVENTARIO_EQUIPO,$equipo,'','onkeypress="ocultarDiv(\'error_equipo\');"');
			$form->addError('error_equipo',ERROR_INVENTARIO_EQUIPO);

			$marcas = $iniData->getTipoMarcas('1','inm_nombre');
			$opciones=null;
			if(isset($marcas)){
				foreach($marcas as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(INVENTARIO_MARCA);
			$form->addSelect('select','sel_marca','sel_marca',$opciones,INVENTARIO_MARCA,$marca,'','onkeypress="ocultarDiv(\'error_marca\');"');
			$form->addError('error_marca',ERROR_INVENTARIO_MARCA);

			$form->addEtiqueta(INVENTARIO_MODELO);
			$form->addInputText('text','txt_modelo','txt_modelo','25','25',$modelo,'','onkeypress="ocultarDiv(\'error_modelo\');"');
			$form->addError('error_modelo',ERROR_INVENTARIO_MODELO);

			$form->addEtiqueta(INVENTARIO_SERIE);
			$form->addInputText('text','txt_serie','txt_serie','25','16',$serie,'','onkeypress="ocultarDiv(\'error_serie\');"');
			$form->addError('error_serie',ERROR_INVENTARIO_SERIE);

			$form->addEtiqueta(INVENTARIO_PLACA);
			$form->addInputText('text','txt_placa','txt_placa','25','15',$placa,'','onkeypress="ocultarDiv(\'error_placa\');"');
			$form->addError('error_placa',ERROR_INVENTARIO_PLACA);

			$form->addEtiqueta(INVENTARIO_FECHA_COMPRA);
			$form->addInputDate('date','txt_fecha_compra','txt_fecha_compra',$fecha,'%Y-%m-%d','16','16','','onkeypress="ocultarDiv(\'error_fecha\');"');
			$form->addError('error_fecha',ERROR_INVENTARIO_FECHA_COMPRA);

			$estados = $iniData->getTipoEstados('1','ies_nombre');
			$opciones=null;
			if(isset($estados)){
				foreach($estados as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(INVENTARIO_ESTADO);
			$form->addSelect('select','sel_estado','sel_estado',$opciones,INVENTARIO_ESTADO,$estado,'','onkeypress="ocultarDiv(\'error_estado\');"');
			$form->addError('error_estado',ERROR_INVENTARIO_ESTADO);

			$form->addEtiqueta(INVENTARIO_DESCRIPCION);
			$form->addTextArea('textarea','txt_descripcion','txt_descripcion','65','5',$descripcion,'','onkeypress="ocultarDiv(\'error_descripcion\');"');
			$form->addError('error_descripcion',ERROR_INVENTARIO_DESCRIPCION);

			//--------------------------------------
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			//-----------------------------------------

			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_involucrado_equipo();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_add_involucrado_equipo\',\'?mod='.$modulo.'&niv='.$niv.'&task=listEquipos&id_element='.$id_involucrado.'&sel_tipo='.$tipo.'&sel_departamento='.$departamento.'&sel_municipio='.$municipio.'&operador='.$operador.'\');"');

			$form->writeForm();

		break;
		/**
		* la variable saveAddEquipo, permite almacenar el objeto INVENTARIO_INVOLUCRADO en la base de datos, ver la clase CInvolucradoInventarioData
		*/
		case 'saveAddEquipo':
			$id_grupo	= $_REQUEST['id_grupo'];

			//variables filtro cargadas en el list
			$operador   	= $_REQUEST['operador'];

			$equipo			= $_REQUEST['sel_equipo'];
			$marca			= $_REQUEST['sel_marca'];
			$modelo			= $_REQUEST['txt_modelo'];
			$serie			= $_REQUEST['txt_serie'];
			$placa			= $_REQUEST['txt_placa'];
			$fecha_compra	= $_REQUEST['txt_fecha_compra'];
			$estado			= $_REQUEST['sel_estado'];
			$descripcion = $_REQUEST['txt_descripcion'];

			

			$equipo = new CInventario('',$id_grupo,$equipo,$marca,$modelo,$serie,$placa,$fecha_compra,$estado,$descripcion,$iniData);
			$m = $equipo->saveNewEquipo();

			echo $html->generaAviso($m,'?mod='.$modulo.'&niv='.$niv.'&task=listEquipos&id_element='.$id_grupo."&operador=".$operador);

		break;
		/**
		* la variable deleteEquipo, permite hacer la carga del objeto INVENTARIO_INVOLUCRADO y espera confirmacion de eliminarlo, ver la clase CInvolucradoInventario
		*/
		case 'deleteEquipo':
			$id_grupo 		= $_REQUEST['id_grupo'];
			$id_equipo  = $_REQUEST['id_element'];

			//variables filtro cargadas en el list
			$operador   	= $_REQUEST['operador'];

			$form = new CHtmlForm();
			$form->setId('frm_delete_involucrado_equipo');
			$form->setMethod('post');
			$form->addInputText('hidden','id_equipo','id_equipo','15','15',$id_equipo,'','');
			$form->addInputText('hidden','id_grupo','id_grupo','15','15',$id_grupo,'','');

			//--------------------------------------
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			//-----------------------------------------
			$form->writeForm();

			echo $html->generaAdvertencia(INVENTARIO_MSG_BORRADO,'?mod='.$modulo.'&niv='.$niv.'&task=confirmDeleteEquipo&id_grupo='.$id_grupo.'&id_equipo='.$id_equipo."&operador=".$operador, "cancelarAccion('frm_delete_involucrado_equipo','?mod=".$modulo."&niv=".$niv."&task=listEquipos&id_element=".$id_grupo."&operador=".$operador."')");

		break;
		/**
		* la variable confirmDeleteVisita, permite eliminar el objeto VISITA de la base de datos, ver la clase CInvolucradoInventarioData
		*/
		case 'confirmDeleteEquipo':
			$id_grupo 		 = $_REQUEST['id_grupo'];
			$id_equipo = $_REQUEST['id_equipo'];

			//variables filtro cargadas en el list
			$operador   	= $_REQUEST['operador'];

			$equipos = new CInventario($id_equipo,'','','','','','','','',$iniData);

			$equipos->loadEquipo();
			$m = $equipos->deleteEquipo();

			echo $html->generaAviso($m,'?mod='.$modulo.'&niv='.$niv.'&task=listEquipos&id_element='.$id_grupo."&operador=".$operador);

		break;
		/**
		* la variable editEquipo, permite hacer la carga  de la página con las variables que componen el objeto VISITA, ver la clase CInvolucradoInventario
		*/
		case 'editEquipo':
			$id_grupo 		  = $_REQUEST['id_grupo'];
			$id_equipo    = $_REQUEST['id_element'];

			//variables filtro cargadas en el list
			$operador   	= $_REQUEST['operador'];

			$form = new CHtmlForm();
			$form->setTitle(EDITAR_EQUIPOS);
			$form->setId('frm_edit_involucrado_equipo');
			 $form->setClassEtiquetas('td_label');
			$form->setMethod('post');

			$form->addInputText('hidden','id_equipo','id_equipo','15','15',$id_equipo,'','');
			$form->addInputText('hidden','id_grupo','id_grupo','15','15',$id_grupo,'','');

			$inventario_equipos = new CInventario($id_equipo,'','','','','','','','','',$iniData);

			$inventario_equipos->loadEquipo();

			if(!isset($_REQUEST['sel_equipo']))	$equipo = $inventario_equipos->getEquipo(); else $equipo = $_REQUEST['sel_equipo'];
			if(!isset($_REQUEST['sel_marca'])) $marca = $inventario_equipos->getMarca(); else $marca = $_REQUEST['sel_marca'];
			if(!isset($_REQUEST['txt_modelo'])) $modelo = $inventario_equipos->getModelo();	else $modelo = $_REQUEST['txt_modelo'];
			if(!isset($_REQUEST['txt_serie'])) $serie = $inventario_equipos->getSerie(); else $serie = $_REQUEST['txt_serie'];
			if(!isset($_REQUEST['txt_placa'])) $placa = $inventario_equipos->getPlaca(); else $placa = $_REQUEST['txt_placa'];
			if(!isset($_REQUEST['txt_fecha_compra'])) $fecha_compra = $inventario_equipos->getFechaCompra(); else $fecha_compra = $_REQUEST['txt_fecha_compra'];
			if(!isset($_REQUEST['sel_estado'])) $estado = $inventario_equipos->getEstado(); else $estado = $_REQUEST['sel_estado'];
			if(!isset($_REQUEST['txt_descripcion'])) $descripcion = $inventario_equipos->getDescripcion(); else $descripcion = $_REQUEST['txt_descripcion'];

			$equipos = $iniData->getTipoEquipos('1','ine_nombre');
			$opciones=null;
			if(isset($equipos)){
				foreach($equipos as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(INVENTARIO_EQUIPO);
			$form->addSelect('select','sel_equipo','sel_equipo',$opciones,INVENTARIO_EQUIPO,$equipo,'','onkeypress="ocultarDiv(\'error_equipo\');"');
			$form->addError('error_equipo',ERROR_INVENTARIO_EQUIPO);

			$marcas = $iniData->getTipoMarcas('1','inm_nombre');
			$opciones=null;
			if(isset($marcas)){
				foreach($marcas as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(INVENTARIO_MARCA);
			$form->addSelect('select','sel_marca','sel_marca',$opciones,INVENTARIO_MARCA,$marca,'','onkeypress="ocultarDiv(\'error_marca\');"');
			$form->addError('error_marca',ERROR_INVENTARIO_MARCA);

			$form->addEtiqueta(INVENTARIO_MODELO);
			$form->addInputText('text','txt_modelo','txt_modelo','16','16',$modelo,'','onkeypress="ocultarDiv(\'error_modelo\');"');
			$form->addError('error_modelo',ERROR_INVENTARIO_MODELO);

			$form->addEtiqueta(INVENTARIO_SERIE);
			$form->addInputText('text','txt_serie','txt_serie','16','16',$serie,'','onkeypress="ocultarDiv(\'error_serie\');"');
			$form->addError('error_serie',ERROR_INVENTARIO_SERIE);

			$form->addEtiqueta(INVENTARIO_PLACA);
			$form->addInputText('text','txt_placa','txt_placa','15','15',$placa,'','onkeypress="ocultarDiv(\'error_placa\');"');
			$form->addError('error_placa',ERROR_INVENTARIO_PLACA);

			$form->addEtiqueta(INVENTARIO_FECHA_COMPRA);
			$form->addInputDate('date','txt_fecha_compra','txt_fecha_compra',$fecha_compra,'%Y-%m-%d','16','16','','onkeypress="ocultarDiv(\'error_fecha\');"');
			$form->addError('error_fecha',ERROR_INVENTARIO_FECHA_COMPRA);

			$estados = $iniData->getTipoEstados('1','ies_nombre');
			$opciones=null;
			if(isset($estados)){
				foreach($estados as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(INVENTARIO_ESTADO);
			$form->addSelect('select','sel_estado','sel_estado',$opciones,INVENTARIO_ESTADO,$estado,'','onkeypress="ocultarDiv(\'error_estado\');"');
			$form->addError('error_estado',ERROR_INVENTARIO_ESTADO);

			$form->addEtiqueta(INVENTARIO_DESCRIPCION);
			$form->addTextArea('textarea','txt_descripcion','txt_descripcion','65','5',$descripcion,'','onkeypress="ocultarDiv(\'error_descripcion\');"');
			$form->addError('error_descripcion',ERROR_INVENTARIO_DESCRIPCION);

			//--------------------------------------
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			//-----------------------------------------

			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_edit_involucrado_equipo();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_edit_involucrado_equipo\',\'?mod='.$modulo.'&niv='.$niv.'&task=listEquipos&id_element='.$id_grupo.'&operador='.$operador.'\');"');

			$form->writeForm();

		break;
		/**
		* la variable saveEditVisita, permite actualizar el objeto VISITA en la base de datos, ver la clase CInvolucradoInventarioData
		*/
		case 'saveEditEquipo':
			$id_grupo 		 = $_REQUEST['id_grupo'];
			$id_equipo = $_REQUEST['id_equipo'];
			//echo("<br>id_involucrado_equipo:".$id_involucrado_equipo);

			//variables filtro cargadas en el list
			$operador   	= $_REQUEST['operador'];

			$equipo			= $_REQUEST['sel_equipo'];
			$marca			= $_REQUEST['sel_marca'];
			$modelo			= $_REQUEST['txt_modelo'];
			$serie			= $_REQUEST['txt_serie'];
			$placa			= $_REQUEST['txt_placa'];
			$fecha_compra	= $_REQUEST['txt_fecha_compra'];
			$estado			= $_REQUEST['sel_estado'];
			$descripcion = $_REQUEST['txt_descripcion'];

			$involucrado_equipo = new CInventario($id_equipo,$id_grupo,$equipo,$marca,$modelo,$serie,$placa,$fecha_compra,$estado,$descripcion,$iniData);

			$m = $involucrado_equipo->saveEditEquipo();

			//redirecciona al list despues de terminar la operacion
			echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=listEquipos&id_element=".$id_grupo."& operador=".$operador);
		break;
		// **************************************************S O P O R T E S*************************************************************

		/**
		* la variable listSoportes, permite hacer la carga la página con la lista de objetos SOPORTE según los parámetros de entrada
		*/
		case 'listSoportes':
			$perfil = $du->getUserPerfil($id_usuario);
			$id_involucrado = $_REQUEST['id_involucrado'];
			$id_inventario	= $_REQUEST['id_element'];

			//variables filtro cargadas en el list
			$tipo			= $_REQUEST['sel_tipo'];
			$departamento	= $_REQUEST['sel_departamento'];
			$municipio		= $_REQUEST['sel_municipio'];
			$operador   	= $_REQUEST['operador'];

			$involucrado_soportes	= $iniData->getSoportesInventario('ins.ini_id='.$id_inventario,$operador);
			$involucrado_equipo 	= $iniData->getNombreInvolucradoEquipo($id_inventario);

			$dt = new CHtmlDataTable();
			$titulos = array(INVOLUCRADOS_SOPORTE_TIPO,INVOLUCRADOS_ARCHIVO);

			$dt->setDataRows($involucrado_soportes);
			$dt->setTitleRow($titulos);

			$dt->setTitleTable(TABLA_SOPORTES."-".$involucrado_equipo);

			//if($perfil==PERFIL_ADMIN || $perfil==PERFIL_ANALISTA){
				$dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=deleteSoporte&id_inventario=".$id_inventario."&id_involucrado=".$id_involucrado."&sel_tipo=".$tipo."&sel_departamento=".$departamento."&sel_municipio=".$municipio."&operador=".$operador);
				$dt->setAddLink("?mod=".$modulo."&niv=".$niv."&task=addSoporte&id_inventario=".$id_inventario."&id_involucrado=".$id_involucrado."&sel_tipo=".$tipo."&sel_departamento=".$departamento."&sel_municipio=".$municipio."&operador=".$operador);
			//}
			$dt->setType(1);

			$dt->writeDataTable($niv);
			$form = new CHtmlForm();
			$form->setId('frm_soporte_involucrado');
			$form->setMethod('post');

			//--------------------------------------
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','sel_tipo','sel_tipo','15','15',$tipo,'','');
			$form->addInputText('hidden','sel_departamento','sel_departamento','15','15',$departamento,'','');
            $form->addInputText('hidden','sel_municipio','sel_municipio','15','15',$municipio,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			//-----------------------------------------

			$form->writeForm();
			$link = "?mod=".$modulo."&task=listEquipos&niv=".$niv."&id_element=".$id_involucrado."&sel_tipo=".$tipo."&sel_departamento=".$departamento."&sel_municipio=".$municipio."&operador=".$operador;
			$html->generaLink($link,'cancelar.gif',BTN_CANCELAR);

		break;
		/**
		* la variable addSoporte, permite hacer la carga la página con las variables que componen el objeto SOPORTE, ver la clase CSoporte
		*/
		case 'addSoporte':
			$id_involucrado = $_REQUEST['id_involucrado'];
			$id_inventario 		= $_REQUEST['id_inventario'];

			//variables filtro cargadas en el list
			$tipo			= $_REQUEST['sel_tipo'];
			$departamento	= $_REQUEST['sel_departamento'];
			$municipio		= $_REQUEST['sel_municipio'];
			$operador   	= $_REQUEST['operador'];

			$tipo_add		= $_REQUEST['sel_tipo_add'];
			$archivo_add 	= $_FILES['file_archivo'];

			$involucrado_equipo = $iniData->getNombreInvolucradoEquipo($id_inventario);

			$form = new CHtmlForm();
			$form->setTitle(AGREGAR_SOPORTES."-".$involucrado_equipo);
			$form->setId('frm_add_inventario_soporte');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$form->addInputText('hidden','id_involucrado','id_involucrado','15','15',$id_involucrado,'','');
			$form->addInputText('hidden','id_inventario','id_inventario','15','15',$id_inventario,'','');

			$tipos = $iniData->getTipoSoportes('1','ist_nombre');
			$opciones=null;
			if(isset($tipos)){
				foreach($tipos as $t){
					$opciones[count($opciones)] = array('value'=>$t['id'],'texto'=>$t['nombre']);
				}
			}
			$form->addEtiqueta(INVOLUCRADOS_SOPORTE_TIPO);
			$form->addSelect('select','sel_tipo_add','sel_tipo_add',$opciones,INVOLUCRADOS_SOPORTE_TIPO,$tipo_add,'','onkeypress="ocultarDiv(\'error_tipo\');"');
			$form->addError('error_tipo',ERROR_INVOLUCRADOS_SOPORTE_TIPO);

			$form->addEtiqueta(INVOLUCRADOS_ARCHIVO);
			$form->addInputFile('file','file_archivo','file_archivo','25','file','onChange="ocultarDiv(\'error_archivo\');"');
			$form->addError('error_archivo',ERROR_INVOLUCRADOS_ARCHIVO);

			//--------------------------------------
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','sel_tipo','sel_tipo','15','15',$tipo,'','');
			$form->addInputText('hidden','sel_departamento','sel_departamento','15','15',$departamento,'','');
            $form->addInputText('hidden','sel_municipio','sel_municipio','15','15',$municipio,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			//-----------------------------------------

			$form->addInputButton('button','ok','ok',BTN_ACEPTAR,'button','onclick="validar_add_inventario_soporte();"');
			$form->addInputButton('button','cancel','cancel',BTN_CANCELAR,'button','onclick="cancelarAccion(\'frm_add_inventario_soporte\',\'?mod='.$modulo.'&niv='.$niv.'&task=listSoportes&id_element='.$id_inventario.'&id_involucrado='.$id_involucrado.'&sel_tipo='.$tipo.'&sel_departamento='.$departamento.'&sel_municipio='.$municipio.'&operador='.$operador.'\');"');

			$form->writeForm();

		break;
		/**
		* la variable saveAddSoporte, permite almacenar el objeto SOPORTE en la base de datos, ver la clase CSoporteData
		*/
		case 'saveAddSoporte':
			$id_involucrado	= $_REQUEST['id_involucrado'];
			$id_inventario	= $_REQUEST['id_inventario'];

			//variables filtro cargadas en el list
			$tipo			= $_REQUEST['sel_tipo'];
			$departamento	= $_REQUEST['sel_departamento'];
			$municipio		= $_REQUEST['sel_municipio'];
			$operador   	= $_REQUEST['operador'];

			$tipo_add		= $_REQUEST['sel_tipo_add'];
			$archivo_add 	= $_FILES['file_archivo'];

			$involucrado_soporte = new CInventarioSoporte('',$id_inventario,$tipo_add,$archivo_add,$iniData);
			$m = $involucrado_soporte->saveNewSoporte($operador);

			echo $html->generaAviso($m,'?mod='.$modulo.'&niv='.$niv.'&task=listSoportes&id_element='.$id_inventario.'&id_involucrado='.$id_involucrado."&sel_tipo=".$tipo."&sel_departamento=".$departamento."&sel_municipio=".$municipio."&operador=".$operador);

		break;
		/**
		* la variable deleteSoporte, permite hacer la carga del objeto SOPORTE y espera confirmacion de eliminarlo, ver la clase CInvolucradoSoporte
		*/
		case 'deleteSoporte':
			$id_involucrado 			= $_REQUEST['id_involucrado'];
			$id_inventario				= $_REQUEST['id_inventario'];
			$id_involucrado_soporte     = $_REQUEST['id_element'];

			//variables filtro cargadas en el list
			$tipo			= $_REQUEST['sel_tipo'];
			$departamento	= $_REQUEST['sel_departamento'];
			$municipio		= $_REQUEST['sel_municipio'];
			$operador   	= $_REQUEST['operador'];

			$form = new CHtmlForm();
			$form->setId('frm_delete_involucrado_soporte');
			$form->setMethod('post');
			$form->addInputText('hidden','id_involucrado_soporte','id_involucrado_soporte','15','15',$id_involucrado_soporte,'','');
			$form->addInputText('hidden','id_involucrado','id_involucrado','15','15',$id_involucrado,'','');

			//--------------------------------------
			//variables cargadas en el list para no perder los filtros
			$form->addInputText('hidden','sel_tipo','sel_tipo','15','15',$tipo,'','');
			$form->addInputText('hidden','sel_departamento','sel_departamento','15','15',$departamento,'','');
            $form->addInputText('hidden','sel_municipio','sel_municipio','15','15',$municipio,'','');
			$form->addInputText('hidden','operador','operador','15','15',$operador,'','');
			//-----------------------------------------
			$form->writeForm();

			echo $html->generaAdvertencia(SOPORTE_MSG_BORRADO,'?mod='.$modulo.'&niv='.$niv.'&task=confirmDeleteSoporte&id_inventario='.$id_inventario.'&id_involucrado='.$id_involucrado.'&id_involucrado_soporte='.$id_involucrado_soporte.'&sel_tipo='.$tipo.'&sel_departamento='.$departamento.'&sel_municipio='.$municipio.'&operador='.$operador,"cancelarAccion('frm_delete_involucrado_soporte','?mod=".$modulo."&niv=".$niv."&task=listSoportes&id_element=".$id_inventario."&id_involucrado=".$id_involucrado."&sel_tipo=".$tipo."&sel_departamento=".$departamento."&sel_municipio=".$municipio."&operador=".$operador."')");

		break;
		/**
		* la variable confirmDeleteSoporte, permite eliminar el objeto SOPORTE de la base de datos, ver la clase CInvolucradoInventarioData
		*/
		case 'confirmDeleteSoporte':
			$id_involucrado 		 = $_REQUEST['id_involucrado'];
			$id_inventario 			 = $_REQUEST['id_inventario'];
			$id_involucrado_soporte  = $_REQUEST['id_involucrado_soporte'];

			//variables filtro cargadas en el list
			$tipo			= $_REQUEST['sel_tipo'];
			$departamento	= $_REQUEST['sel_departamento'];
			$municipio		= $_REQUEST['sel_municipio'];
			$operador   	= $_REQUEST['operador'];

			$involucrado_soportes = new CInventarioSoporte($id_involucrado_soporte,'','','',$iniData);

			$involucrado_soportes->loadSoporte();
			$m = $involucrado_soportes->deleteSoporte();

			echo $html->generaAviso($m,'?mod='.$modulo.'&niv='.$niv.'&task=listSoportes&id_element='.$id_inventario.'&id_involucrado='.$id_involucrado."&sel_tipo=".$tipo."&sel_departamento=".$departamento."&sel_municipio=".$municipio."&operador=".$operador);

		break;
		/**
		* la variable listResumenExcel, permite generar en excel el objeto DOCUMENTO(comunicado) a partir de la base de datos
		*/
		case 'listResumenExcel':

			$operador=$_REQUEST['operador'];

			$form = new CHtmlForm();
			$form->setTitle(EXCEL_INVENTARIOS);
			$form->setId('frm_excel');
			$form->setMethod('post');
			$form->setClassEtiquetas('td_label');

			$form->addInputText('hidden','operador','operador','45','20',$operador,'','');

			$form->writeForm();

			$form->crearBoton('button','guardar',BTN_ACEPTAR,'onclick="involucrados_inventario_en_excel();"');

		break;
		/**
		* en caso de que la variable task no este definida carga la página en construcción
		*/
		default:
			include('templates/html/under.html');

		break;
	}
?>
