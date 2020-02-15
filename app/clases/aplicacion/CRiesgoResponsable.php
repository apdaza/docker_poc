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
* Clase RiesgoResponsable
*
* @package  clases
* @subpackage aplicacion
* @author Alejandro Daza
* @version 2019.02
* @copyright apdaza
*/

class CRiesgoResponsable{
	var $id =  null;
	var $riesgo =  null;
	var $responsable =  null;
	var $db = null;
/**
** Constructor de la clase CRiesgoResponsableData
**/
	function CRiesgoResponsable($id,$riesgo,$nombre,$db){
		$this->id =  $id;
		$this->riesgo =  $riesgo;
		$this->nombre =  $nombre;
		$this->db =$db;
	}
	function getId(){ return	$this->id; }
	function getRiesgo(){ return	$this->riesgo; }
	function getNombre(){ return	$this->nombre; }
/**
** carga los valores de un objeto RESPONSABLE por su id para ser editados
**/			
	function loadResponsable(){
			$r = $this->db->getResponsableById($this->id);
			if($r != -1){
				$this->riesgo =  $r['rie_id'];
				$this->nombre =  $r['doa_nombre'];
			}else{
				$this->id =  "";
				$this->riesgo = "";
				$this->nombre =  "";
			}
	}
/**
** almacena un objeto ENTREGABLE y retorna un mensaje del resultado del proceso
**/		
	function saveNewResponsable(){
		$r = $this->db->insertResponsable($this->riesgo,$this->nombre);
		if($r=='true'){
			$msg = RESPONSABLE_AGREGADO;
		}else{
			$msg = ERROR_ADD_RESPONSABLE;
		}	
		return $msg;
	}
/**
** elimina un objeto ENTREGABLE y retorna un mensaje del resultado del proceso
**/		
	function deleteResponsable(){
		$r = $this->db->deleteResponsable($this->id);
		if($r=='true'){
			$msg = RESPONSABLE_BORRADO;		
		}else{
			$msg = ERROR_DEL_RESPONSABLE;
		}
		return $msg;
	}
/**
** actualiza un objeto ENTREGABLE y retorna un mensaje del resultado del proceso
**/		
	function saveEditResponsables($responsables){
		if (isset($responsables))
			$i = 0;
			foreach($responsables as $r){
				if($i == 0)
				$responsable .= $r['id'];
				else $responsable .= ",".$r['id'];
				$i++;
			}
			$this->db->updateResponsables($this->id,$responsable);
	}
}
?>