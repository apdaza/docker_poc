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
* Clase RiesgoAccion
*
* @package  clases
* @subpackage aplicacion
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/

Class CRiesgoAccion{
	var $id =  null;
	var $riesgo =  null;
	var $accion =  null;
	var $responsable =  null;
	var $fecha_accion =  null;
	var $impacto =  null;
	var $probabilidad =  null;
	var $categoria =  null;
	var $categoriaNombre =  null;
	var $db = null;
/**
** Constructor de la clase CRiesgoAccionData
**/	
function CRiesgoAccion($id,$riesgo,$accion,$responsable,$fecha_accion,$impacto,$probabilidad,$categoria,$categoriaNombre,$db){
		$this->id 				=  $id;
		$this->riesgo 			=  $riesgo;
		$this->accion 			=  $accion;
		$this->responsable 		=  $responsable;
		$this->impacto 			=  $impacto;
		$this->probabilidad 	=  $probabilidad;
		$this->categoria 		=  $categoria;	
		$this->categoriaNombre 	=  $categoriaNombre;	
		$this->fechaAccion 		=  $fecha_accion;
		$this->db 				=  $db;
	}
	function getId(){ 				return	$this->id; 				}
	function getRiesgo(){ 			return	$this->riesgo; 			}
	function getAccion(){ 			return	$this->accion; 			}
	function getResponsable(){ 		return	$this->responsable; 	}
	function getImpacto(){ 			return	$this->impacto; 		}
	function getProbabilidad(){ 	return	$this->probabilidad; 	}
	function getCategoria(){ 		return	$this->categoria; 		}
	function getCategoriaNombre(){ 	return	$this->categoriaNombre; }
	function getFechaAccion(){ 		return	$this->fechaAccion; 	}
/**
** carga los valores de un objeto ACCION por su id para ser editados
**/	
	function loadAccion(){
			$r = $this->db->getAccionById($this->id);
			if($r != -1){
				$this->id 			=  $r['rac_id'];
				$this->riesgo 		=  $r['rie_id'];
				$this->accion 		=  $r['rac_descripcion'];
				$this->responsable 	=  $r['deq_id'];
				$this->impacto 		=  $r['rim_id'];
				$this->probabilidad =  $r['rpr_id'];	
				$this->categoria 	=  $r['rca_id'];					
				$this->fechaAccion 	=  $r['rac_fecha'];
			}else{
				$this->id 			=  "";
				$this->riesgo 		= "";
				$this->accion 		=  "";
				$this->responsable 	= "";
				$this->impacto 		=  "";
				$this->probabilidad =  "";				
				$this->categoria 	=  "";					
				$this->fechaAccion 	= "";
			}
	}
/**
** almacena un objeto ACCION y retorna un mensaje del resultado del proceso
**/		
	function saveNewAccion(){
		$r = $this->db->insertAccion($this->riesgo,$this->accion,$this->responsable,$this->impacto,$this->probabilidad,$this->categoria,$this->categoriaNombre,$this->fechaAccion);
		if($r=='true'){
			$msg = ACCION_AGREGADO;
		}else{
			$msg = ERROR_ADD_ACCION;
		}	
		return $msg;
	}
/**
** elimina un objeto ACCION y retorna un mensaje del resultado del proceso
**/		
	function deleteAccion($riesgo){
		$r = $this->db->deleteAccion($this->id,$riesgo);
		if($r=='true'){
			$msg = ACCION_BORRADO;		
		}else{
			$msg = ERROR_DEL_ACCION;
		}
		return $msg;
	}
/**
** actualiza un objeto ACCION y retorna un mensaje del resultado del proceso
**/		
	function saveEditAccion(){
		$r = $this->db->updateAccion($this->id,$this->riesgo,$this->accion,$this->responsable,$this->fechaAccion,$this->impacto,$this->probabilidad,$this->categoria,$this->categoriaNombre);		
		if($r=='true'){
			$msg = ACCION_EDITADO;
		}else{
			$msg = ERROR_EDIT_ACCION;
		}
		return $msg;	
	}
}
?>