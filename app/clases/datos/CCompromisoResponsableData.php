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
* Clase CompromisoResponsableData
* Usada para la definicion de todas las funciones propias del objeto COMPROMISO_RESPONSABLE
*
* @package  clases
* @subpackage datos
* @author Alejandro Daza
* @version 2019.02
* @copyright apdaza
*/
Class CCompromisoResponsableData{
    var $db = null;
	
	function CCompromisoResponsableData($db){
		$this->db = $db;
	}
	
	function getResponsableById($id){
		$sql = "SELECT cr.cor_id,cr.com_id,cr.doa_id, r.doa_nombre
                        FROM compromiso_responsable cr, documento_actor r 
			WHERE r.doa_id = cr.doa_id and cr.cor_id= ". $id;
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}
	
	function insertResponsable($compromiso,$nombre){
		$tabla = "compromiso_responsable";
		$campos = "com_id,doa_id";
		$valores = "'".$compromiso."','".$nombre."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function deleteResponsable($id){
		$tabla = "compromiso_responsable";
		$predicado = "cor_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
}