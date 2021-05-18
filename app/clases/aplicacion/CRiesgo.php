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
* Clase Riesgo
*
* @package  clases
* @subpackage aplicacion
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/

Class CRiesgo{
	var $id 				= null;
	var $descripcion 		= null;
	var $fecha_deteccion 	= null;
	var $estrategia 		= null;
	var $accion 			= null;
	var $impacto 			= null;
	var $probabilidad 		= null;
	var $categoria 			= null;
	var $alcance 			= null;
	var $estado 			= null;
    var $cc 				= null;
/**
** Constructor de la clase CRiesgoData
**/	
	function CRiesgo($id,$descripcion,$fecha_deteccion,$estrategia,$accion,$impacto,$probabilidad,$categoria,$alcance,$estado,$cc){
		$this->id 				= $id;
		$this->descripcion 		= $descripcion;
		$this->fecha_deteccion 	= $fecha_deteccion;
		$this->estrategia 		= $estrategia;
		$this->accion 			= $accion;
		$this->impacto 			= $impacto;
		$this->probabilidad 	= $probabilidad;
		$this->categoria 		= $categoria;
		$this->alcance 			= $alcance;
		$this->estado 			= $estado;
		$this->cc 				= $cc;
	}
	function getId(){ 				return $this->id;				}
	function getDescripcion(){ 		return $this->descripcion;		}
	function getFechaDeteccion(){	return $this->fecha_deteccion;	}
	function getEstrategia(){ 		return $this->estrategia;		}
	function getAccion(){ 			return $this->accion;			}
	function getImpacto(){ 			return $this->impacto;			}
	function getProbabilidad(){ 	return $this->probabilidad;		}
	function getCategoria(){ 		return $this->categoria;		}
	function getAlcance(){ 			return $this->alcance;			}
	function getEstado(){ 			return $this->estado;			}
/**
** carga los valores de un objeto RIESGO por su id para ser editados
**/		
	function loadRiesgo(){
		$r = $this->cc->getRiesgoById($this->id);
		if($r != -1){
			$this->id 					= $r['rie_id'];
			$this->descripcion 			= $r['rie_descripcion'];
			$this->fecha_deteccion 		= $r['rie_fecha_deteccion'];
			$this->fecha_actualizacion 	= $r['rie_fecha_actualizacion'];
			$this->estrategia 			= $r['rie_estrategia'];
			$this->impacto 				= $r['rim_id'];
			$this->probabilidad 		= $r['rpr_id'];
			$this->categoria 			= $r['rca_id'];
			$this->alcance 				= $r['alc_id'];
			$this->estado 				= $r['res_id'];
		}else{
			$this->id 					= "";
			$this->descripcion 			= "";
			$this->fecha_deteccion 		= "";
			$this->fecha_actualizacion 	= "";
			$this->estrategia 			= "";
			$this->impacto 				= "";
			$this->probabilidad 		= "";
			$this->categoria 			= "";
			$this->alcance 				= "";
			$this->estado 				= "";
		}
	}

/**
** almacena un objeto RIESGO y retorna un mensaje del resultado del proceso
**/		
	function saveNewRiesgo(){
		$i = $this->cc->insertRiesgo($this->descripcion,$this->fecha_deteccion,$this->estrategia,$this->impacto,$this->probabilidad,$this->categoria,$this->alcance,$this->estado);
		if($i == "true"){
			$r = RIESGO_AGREGADO;
		}else{
			$r = ERROR_ADD_RIESGO;
		}
		return $r;
	}
/**
** elimina un objeto RIESGO y retorna un mensaje del resultado del proceso
**/		
	function deleteRiesgo(){
		$r = $this->cc->deleteRiesgo($this->id);
		if($r=='true'){
			$msg = RIESGO_BORRADO;		
		}else{
			$msg = ERROR_DEL_RIESGO;
		}
		return $msg;
	}
/**
** actualiza un objeto RIESGO y retorna un mensaje del resultado del proceso
**/		
	function saveEditRiesgo(){
		$r = $this->cc->updateRiesgo($this->id,$this->descripcion,$this->fecha_deteccion,$this->estrategia,$this->impacto,$this->probabilidad,$this->categoria,$this->alcance,$this->estado);
		if($r=='true'){
			$msg = RIESGO_EDITADO;
		}else{
			$msg = ERROR_EDIT_RIESGO;
		}
		return $msg;	
	}
}
?>