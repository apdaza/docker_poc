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
* Clase CObligacionConcIntData
* Usada para la definicion de todas las funciones propias del objeto OBLIGACION
*
* @package  clases
* @subpackage datos
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/
Class CObligacionConcIntData{
    var $db = null;

	function CObligacionConcIntData($db){
		$this->db = $db;
	}

	function getObligaciones($criterio){
		$salida = null;
		$sql = "select *
				from obligacion_concesion    ocs
				inner join obligacion_clausula      obc on obc.obc_id=ocs.obc_id
				inner join obligacion_componente    oco on oco.oco_id=ocs.oco_id
				inner join obligacion_conc_int      oci on oci.ocs_id=ocs.ocs_id
				inner join obligacion_interventoria obi on obi.obi_id=oci.obi_id
				where ". $criterio;
		//echo("<br>".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 			= $w['oci_id'];
				$salida[$cont]['componente'] 	= $w['oco_nombre'];
				$salida[$cont]['clausula'] 		= $w['obc_nombre'];
				$salida[$cont]['literal'] 		= $w['ocs_literal']."-".$w['ocs_descripcion'];
				$salida[$cont]['obligacion'] 	= $w['obi_literal']."-".$w['obi_descripcion'];
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
	function getLiterales($criterio,$orden){
		$salida = null;
		$sql = "select *
				FROM  obligacion_concesion
				where ". $criterio ." order by ".$orden;
				//echo($sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 	 = $w['ocs_id'];
				$salida[$cont]['nombre'] = substr($w['ocs_literal']."-".$w['ocs_descripcion'],0,150);
				$cont++;
			}
		}
		return $salida;
	}
	function getObligacionesInterventoria($criterio,$orden){
		$salida = null;
		$sql = "select *
				FROM  obligacion_interventoria
				where ". $criterio ." order by ".$orden;
				//echo($sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 	 = $w['obi_id'];
				$salida[$cont]['nombre'] = substr($w['obi_literal']."-".$w['obi_descripcion'],0,150);
				$cont++;
			}
		}
		return $salida;
	}
	function insertObligacion($obligacion_conc,$obligacion_int){
		$tabla = "obligacion_conc_int";
		$campos = "ocs_id,obi_id";
		$valores = "'".$obligacion_conc."','".$obligacion_int."'";

		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	function deleteObligacionConcInt($id){
		//echo $id;
		$tabla = "obligacion_conc_int ";
		$predicado = "oci_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}

	function getObligacionById($id){
		$opcion = null;
		$sql = "select *
				from obligacion_concesion    ocs
				inner join obligacion_clausula   obc on obc.obc_id=ocs.obc_id
				inner join obligacion_componente oco on oco.oco_id=ocs.oco_id
				where   ocs.ocs_id = ". $id;
		//echo $sql;
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r){
			$opcion["id"] 			 = $r["ocs_id"];
			$opcion["componente"] 	 = $r["oco_id"];
			$opcion["clausula"] 	 = $r["obc_id"];
			$opcion["literal"] 		 = $r["ocs_literal"];
			$opcion["descripcion"] 	 = $r["ocs_descripcion"];
			//$opcion["obligacion_int"]= $r["obi_id"];
			$opcion["periodicidad"]	 = $r["obp_id"];
			$opcion["criterio"]		 = $r["ocs_criterio"];
			return $opcion;
		}else{
			return -1;
		}
	}

	function getObligacionIdByRelacion($oblig_conc,$oblig_int){
		$pre = "ocs_id = '". $oblig_conc ."' and obi_id='".$oblig_int."'";
		$r = $this->db->recuperarCampo('obligacion_conc_int','oci_id',$pre);
		if($r) return $r; else return -1;
	}
	function getObligacionId($l){
		$pre = "ocs_id = '". $l ."'";
		$r = $this->db->recuperarCampo('obligacion_concesion','ocs_descripcion',$pre);
		if($r) return $r; else return -1;
	}



}
?>
