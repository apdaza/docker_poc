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
* Clase DocumentoEquipos
*
* @package  clases
* @subpackage aplicacion
* @author Alejandro Daza
* @version 2019.02
* @copyright apdaza
*/

Class CDocumentoEquipo{
	var $id = null;
	var $actor = null;
	var $responsable = null;
	var $controla_alarmas = null;
    var $ee = null;
/**
** Constructor de la clase COpcionData
**/				
	function CDocumentoEquipo($id,$actor,$responsable,$controla_alarmas,$ee){
		$this->id = $id;
		$this->actor = $actor;
		$this->responsable = $responsable;
		$this->controla_alarmas = $controla_alarmas;
		$this->ee = $ee;
	}
	function getActor(){ 			return $this->actor;			}
	function getResponsable(){ 		return $this->responsable;		}
	function getControlaAlarmas(){ 	return $this->controla_alarmas;	}
/**
** carga los valores de un objeto EQUIPO por su id para ser editados
**/	
	function loadEquipo(){
		$r = $this->ee->getEquipoById($this->id);
		if($r != -1){
			$this->id 				= $r['deq_id'];
			$this->actor 			= $r['des_id'];
			$this->responsable 		= $r['usu_id'];
			$this->controla_alarmas = $r['deq_controla_alarmas'];
		}else{
			$this->id 				= "";
			$this->actor 			= "";
			$this->responsable 		= "";
			$this->controla_alarmas = "";
		}
	}
/**
** almacena un objeto EQUIPO y retorna un mensaje del resultado del proceso
**/		
	function saveNewEquipo(){
		$i = $this->ee->insertEquipo($this->actor,$this->responsable,$this->controla_alarmas);
		if($i == "true"){
			$r = EQUIPO_AGREGADO;
		}else{
			$r = ERROR_ADD_EQUIPO;
		}
		return $r;
	}
/**
** elimina un objeto EQUIPO y retorna un mensaje del resultado del proceso
**/		
	function deleteEquipo(){
		$r = $this->ee->deleteEquipo($this->id);
		if($r=='true'){
			$msg = EQUIPO_BORRADO;		
		}else{
			$msg = ERROR_DEL_EQUIPO;
		}
		return $msg;
	}
}
?>