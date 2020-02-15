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
* Clase CObligacionInterventoriaData
* Usada para la definicion de todas las funciones propias del objeto OBLIGACION
*
* @package  clases
* @subpackage datos
* @author Alejandro Daza
* @version 2019.02
* @copyright apdaza
*/
Class CObligacionInterventoriaData{
    var $db = null;

	function CObligacionInterventoriaData($db){
		$this->db = $db;
	}

	function getObligaciones($criterio,$orden){
		$salida = null;
		$sql = "select *
				from obligacion_interventoria    obi
				inner join obligacion_clausula   obc on obc.obc_id=obi.obc_id
				inner join obligacion_componente oco on oco.oco_id=obi.oco_id
				where ". $criterio." order by ".$orden;
		//echo("<br>".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 			= $w['obi_id'];
				$salida[$cont]['componente'] 	= $w['oco_nombre'];
				$salida[$cont]['clausula'] 		= $w['obc_nombre'];
				$salida[$cont]['literal'] 		= $w['obi_literal'];
				$salida[$cont]['descripcion'] 	= $w['obi_descripcion'];
				$cont++;
			}
		}

		return $salida;
	}

	function getClausulas($criterio,$orden){
		$salida = null;
		$sql = "select *
				FROM  obligacion_clausula
				where ". $criterio ." order by ".$orden;
				//echo($sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 	 = $w['obc_id'];
				$salida[$cont]['nombre'] = $w['obc_nombre'];
				$cont++;
			}
		}
		return $salida;
	}
	function getComponentes($criterio,$orden){
		$salida = null;
		$sql = "select *
				FROM  obligacion_componente
				where ". $criterio ." order by ".$orden;
				//echo($sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 	 = $w['oco_id'];
				$salida[$cont]['nombre'] = $w['oco_nombre'];
				$cont++;
			}
		}
		return $salida;
	}
	function insertObligacion($componente,$clausula,$literal,$descripcion){
		$tabla = "obligacion_interventoria";
		$campos = "oco_id,obc_id,obi_literal,obi_descripcion";
		$valores = "'".$componente."','".$clausula."','".$literal."','".$descripcion."'";

		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	function deleteObligacion($id){
		//echo $id;
		$tabla = "obligacion_interventoria ";
		$predicado = "obi_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	function updateObligacion($id,$componente,$clausula,$literal,$descripcion){
		$tabla = "obligacion_interventoria";
		$campos = array('oco_id','obc_id','obi_literal','obi_descripcion');
		$valores = array("'".$componente."'","'".$clausula."'","'".$literal."'","'".$descripcion."'");

		$condicion = "obi_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}
	function getObligacionById($id){
		$opcion = null;
		$sql = "select *
				from obligacion_interventoria    obi
				inner join obligacion_clausula   obc on obc.obc_id=obi.obc_id
				inner join obligacion_componente oco on oco.oco_id=obi.oco_id
				where   obi.obi_id = ". $id;
		//echo $sql;
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r){
			$opcion["id"] 			= $r["obi_id"];
			$opcion["componente"] 	= $r["oco_id"];
			$opcion["clausula"] 	= $r["obc_id"];
			$opcion["literal"] 		= $r["obi_literal"];
			$opcion["descripcion"] 	= $r["obi_descripcion"];
			return $opcion;
		}else{
			return -1;
		}
	}
	function getObligacionIdByDescripcion($l){
		$pre = "obi_descripcion = '". $l ."'";
		$r = $this->db->recuperarCampo('obligacion_interventoria','obi_id',$pre);
		if($r) return $r; else return -1;
	}
}
?>
