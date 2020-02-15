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
* Clase RiesgoResponsableData
* Usada para la definicion de todas las funciones propias del objeto RIESGO_RESPONSABLE
*
* @package  clases
* @subpackage datos
* @author Alejandro Daza
* @version 2019.02
* @copyright apdaza
*/
Class CRiesgoResponsableData{
    var $db = null;
	
	function CRiesgoResponsableData($db){
		$this->db = $db;
	}
	
	function getResponsableById($id){
		$sql = "select cr.rir_id,cr.rie_id,cr.doa_id, r.doa_nombre
					from riesgo_responsable cr, documento_actor r 
					where r.doa_id = cr.doa_id and cr.rir_id= ". $id;
		//echo($sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}
	
	function insertResponsable($riesgo,$nombre){
		$tabla = "riesgo_responsable";
		$campos = "rie_id,doa_id";
		$valores = "'".$riesgo."','".$nombre."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function deleteResponsable($id){
		$tabla = "riesgo_responsable";
		$predicado = "rir_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
}