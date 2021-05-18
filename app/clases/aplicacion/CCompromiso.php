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
* Clase Compromiso
*
* @package  clases
* @subpackage aplicacion
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/

Class CCompromiso{
	var $id = null;
	var $actividad = null;
	var $tema = null;
	var $subtema = null;
	var $referencia = null;
	var $fecha_limite = null;
	var $fecha_entrega = null;
	var $estado = null;
	var $observaciones = null;        
    var $operador = null;                
    var $cc = null;
/**
** Constructor de la clase CCompromisoData
**/	
    function CCompromiso($id,$actividad,$tema,$subtema,$referencia,$fecha_limite,$fecha_entrega,$estado,$observaciones,$operador,$cc){
		$this->id 			= $id;
		$this->actividad 	= $actividad;
		$this->tema 		= $tema;
		$this->subtema 		= $subtema;
		$this->referencia 	= $referencia;
		$this->fecha_limite = $fecha_limite;
		$this->fecha_entrega= $fecha_entrega;
		$this->estado 		= $estado;
		$this->observaciones= $observaciones;
		$this->operador 	= $operador;
		$this->cc 			= $cc;
	}
	function getId(){ 				return $this->id;				}
	function getActividad(){ 		return $this->actividad;		}
	function getTema(){ 			return $this->tema;				}
	function getSubtema(){ 			return $this->subtema;			}
	function getReferencia(){ 		return $this->referencia;		}
	function getFechaLimite(){ 		return $this->fecha_limite;		}
	function getFechaEntrega(){ 	return $this->fecha_entrega;	}
	function getEstado(){ 			return $this->estado;			}
	function getObservaciones(){ 	return $this->observaciones;	}
	function getOperador(){ 		return $this->operador;			}
/**
** carga los valores de un objeto COMPROMISO por su id para ser editados
**/
	function loadCompromiso(){
		$r = $this->cc->getCompromisoById($this->id);
		if($r != -1){
			$this->id 				= $r['com_id'];
			$this->actividad 		= $r['com_actividad'];
			$this->tema 			= $r['dot_id'];
			$this->subtema 			= $r['dos_id'];
			$this->referencia 		= $r['doc_id'];
			$this->fecha_limite 	= $r['com_fecha_limite'];
			$this->fecha_entrega	= $r['com_fecha_entrega'];
			$this->estado 			= $r['ces_id'];
			$this->observaciones 	= $r['com_observaciones'];
		}else{
			$this->id 				= "";
			$this->actividad 		= "";
			$this->tema 			= "";
			$this->subtema 			= "";
			$this->referencia 		= "";
			$this->fecha_entrega 	= "";
			$this->fecha_limite 	= "";
			$this->estado 			= "";
			$this->observaciones 	= "";
		}
	}
/**
** carga los valores de un objeto COMPROMISO por su id para ser visualizados
**/
	function loadSeeCompromiso(){

		$r = $this->cc->getCompromisosSee($this->id);
		if($r != -1){
			$this->id 				= $r['com_id'];
			$this->actividad 		= $r['com_actividad'];
			$this->tema 			= $r['dot_id'];
			$this->subtema 			= $r['dos_id'];
			$this->referencia 		= $r['doc_id'];
			$this->fecha_limite 	= $r['com_fecha_limite'];
			$this->fecha_entrega 	= $r['com_fecha_entrega'];
			$this->estado 			= $r['ces_id'];
			$this->observaciones 	= $r['com_observaciones'];
		}else{
			$this->id 				= "";
			$this->actividad 		= "";
			$this->tema 			= "";
			$this->referencia 		= "";
			$this->fecha_entrega 	= "";
			$this->fecha_limite 	= "";
			$this->estado 			= "";
			$this->observaciones 	= "";
		}
	}
/**
** almacena un objeto COMPROMISO y retorna un mensaje del resultado del proceso
**/				
	function saveNewCompromiso(){
		$i = $this->cc->insertCompromiso($this->actividad,$this->referencia,$this->fecha_limite,$this->fecha_entrega,$this->estado,$this->observaciones,$this->operador);
		if($i == "true"){
			$r = COMPROMISO_AGREGADO;
		}else{
			$r = ERROR_ADD_COMPROMISO;
		}
		return $r;
	}
/**
** elimina un objeto COMPROMISO y retorna un mensaje del resultado del proceso
**/				
	function deleteCompromiso(){
		$r = $this->cc->deleteCompromiso($this->id);
		if($r=='true'){
			$msg = COMPROMISO_BORRADO;		
		}else{
			$msg = ERROR_DEL_COMPROMISO;
		}
		return $msg;
	
	}
/**
** actualiza un objeto COMPROMISO y retorna un mensaje del resultado del proceso
**/				
	function saveEditCompromiso(){
		$r = $this->cc->updateCompromiso($this->id,$this->actividad,$this->referencia,$this->fecha_limite,$this->fecha_entrega,$this->estado,$this->observaciones);
		if($r=='true'){
			$msg = COMPROMISO_EDITADO;
		}else{
			$msg = ERROR_EDIT_COMPROMISO;
		}
		return $msg;	
	}
}

?>