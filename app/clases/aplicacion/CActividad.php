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
* Clase CActividad
*
* @package  clases
* @subpackage aplicacion
* @author Alejandro Daza
* @version 2019.02
* @copyright apdaza
*/

class CActividad{
	var $id = null;
	var $descripcion = null;
  var $fecha_inicio = null;
  var $fecha_fin = null;
  var $usuario = null;
  var $estado = null;
  var $inconvenientes = null;
  var $subsistema = null;
	var $cob = null;

/**
** Constructor de la clase CActividad
**/
	function CActividad($id,$descripcion,$fecha_inicio,$fecha_fin,$usuario,$estado,$inconvenientes,$subsistema,$cob){
		$this->id = $id;
		$this->descripcion = $descripcion;
		$this->fecha_inicio = $fecha_inicio;
		$this->fecha_fin = $fecha_fin;
		$this->usuario = $usuario;
		$this->estado = $estado;
		$this->inconvenientes = $inconvenientes;
		$this->subsistema = $subsistema;
		$this->cob = $cob;
	}

	function getId(){	return $this->id;	}
	function getDescripcion(){ return $this->descripcion;	}
	function getFechaInicio(){ return $this->fecha_inicio; }
	function getFechaFin(){ return $this->fecha_fin; }
	function getUsuario(){ return $this->usuario; }
	function getEstado(){ return $this->estado; }
	function getInconvenientes(){ return $this->inconvenientes; }
	function getSubsistema(){ return $this->subsistema; }

/**
** carga los valores de un objeto actividad por su id para ser editados
**/
	function loadActividad(){
		$r = $this->cob->getActividadById($this->id);
		if($r != -1){
			$this->descripcion = $r['descripcion'];
			$this->fecha_inicio	= $r['fecha_inicio'];
      $this->$fecha_fin = $r['fecha_fin'];
      $this->usuario = $r['usuario'];
      $this->estado = $r['estado'];
      $this->inconvenientes = $r['inconvenientes'];
      $this->subsistema = $r['subsistema'];

		}else{
			$this->descripcion = "";
			$this->fecha_inicio	= "";
      $this->$fecha_fin = "";
      $this->usuario = "";
      $this->estado = "";
      $this->inconvenientes = "";
      $this->subsistema = "";
		}
	}
/**
** almacena un objeto actividad y retorna un mensaje del resultado del proceso
**/
	function saveNewActidad(){
		$valid = $this->cob->getActividadIdByDescripcion($this->descripcion);
		if($valid!=-1){
			$msg = ACTIVIDAD_EXISTENTE;
		}
		if($valid==-1){
			$r = $this->cob->insertActividad($this->descripcion,$this->fecha_inicio,$this->fecha_fin,$this->usuario,$this->estado,$this->inconvenientes,$this->subsistema);
			if($r=='true'){
				$msg = ACTIVIDAD_AGREGADO;
			}else{
				$msg = ERROR_ADD_ACTIVIDAD;
			}
		}
		return $msg;
	}
/**
** elimina un objeto actividad y retorna un mensaje del resultado del proceso
**/
	function deleteActividad(){
		$r = $this->cob->deleteActividad($this->id);
		if($r=='true'){
			$msg = ACTIVIDAD_BORRADO;
		}else{
			$msg = ERROR_DEL_ACTIVIDAD;
		}
		return $msg;
	}
/**
** actualiza un objeto OBLIGACION y retorna un mensaje del resultado del proceso
**/
	function saveEditActividad(){
		$r = $this->cob->updateActividad($this->id,$this->descripcion,$this->fecha_inicio,$this->fecha_fin,$this->usuario,$this->estado,$this->inconvenientes,$this->subsistema);
		if($r=='true'){
			$msg = ACTIVIDAD_EDITADO;
		}else{
			$msg = ERROR_EDIT_ACTIVIDAD;
		}
		return $msg;
	}
}
?>
