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
* Clase CObligacionInterventoria
*
* @package  clases
* @subpackage aplicacion
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/

class CObligacionInterventoria{
	var $id 			= null;
	var $componente		= null;
	var $clausula 		= null;
	var $literal 		= null;
	var $descripcion 	= null;
	var $cob 			= null;

/**
** Constructor de la clase CObligacionInterventoriaData
**/
	function CObligacionInterventoria($id,$componente,$clausula,$literal,$descripcion,$cob){
		$this->id 			= $id;
		$this->componente	= $componente;
		$this->clausula 	= $clausula;
		$this->literal 		= $literal;
		$this->descripcion	= $descripcion;
		$this->cob 			= $cob;
	}
	function getId(){			return $this->id;		}
	function getComponente(){	return $this->componente;	}
	function getClausula(){		return $this->clausula;	}
	function getLiteral(){		return $this->literal;	}
	function getDescripcion(){	return $this->descripcion;	}

/**
** carga los valores de un objeto OBLIGACION por su id para ser editados
**/
	function loadObligacion(){
		$r = $this->cob->getObligacionById($this->id);
		if($r != -1){
			$this->componente 	= $r['componente'];
			$this->clausula 	= $r['clausula'];
			$this->literal 		= $r['literal'];
			$this->descripcion 	= $r['descripcion'];

		}else{
			$this->componente 		= "";
			$this->clausula 		= "";
			$this->literal 		= "";
			$this->descripcion 	= "";
		}
	}
/**
** almacena un objeto OBLIGACION y retorna un mensaje del resultado del proceso
**/
	function saveNewObligacion(){
		$valid = $this->cob->getObligacionIdByDescripcion($this->descripcion);
		if($valid!=-1){
			$msg = OBLIGACION_EXISTENTE;
		}
		if($valid==-1){
			$r = $this->cob->insertObligacion($this->componente,$this->clausula,$this->literal,$this->descripcion);
			if($r=='true'){
				$msg = OBLIGACION_AGREGADO;
			}else{
				$msg = ERROR_ADD_OBLIGACION;
			}
		}
		return $msg;
	}
/**
** elimina un objeto OBLIGACION y retorna un mensaje del resultado del proceso
**/
	function deleteObligacion(){
		$r = $this->cob->deleteObligacion($this->id);
		if($r=='true'){
			$msg = OBLIGACION_BORRADO;
		}else{
			$msg = ERROR_DEL_OBLIGACION;
		}
		return $msg;
	}
/**
** actualiza un objeto OBLIGACION y retorna un mensaje del resultado del proceso
**/
	function saveEditObligacion(){
		$r = $this->cob->updateObligacion($this->id,$this->componente,$this->clausula,$this->literal,$this->descripcion);
		if($r=='true'){
			$msg = OBLIGACION_EDITADO;
		}else{
			$msg = ERROR_EDIT_OBLIGACION;
		}
		return $msg;
	}
}
?>
