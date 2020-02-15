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
* Clase AlcanceData
* Usada para la definicion de todas las funciones propias del objeto ALCANCE
*
* @package  clases
* @subpackage datos
* @author Alejandro Daza
* @version 2019.02
* @copyright apdaza
*/
Class CAlcanceData{

	var $db = null;

	function CAlcanceData($db){
		$this->db = $db;
	}


	function getAlcances($criterio,$orden){
		$alcance = null;
		$sql = "select a.alc_id, a.alc_nombre, a.alc_fecha_registro, a.deq_id_contratante,a.deq_id_contratista,a.deq_id_interventoria,a.alc_reunion,
						concat(us1.usu_nombre,' ',us1.usu_apellido) as contratante,
						concat(us2.usu_nombre,' ',us2.usu_apellido) as contratista,
						concat(us3.usu_nombre,' ',us3.usu_apellido) as interventoria,ae.ale_nombre
				from alcance a
				inner join documento_equipo 	de1 on de1.deq_id = a.deq_id_contratante
				inner join usuario 				us1 on de1.usu_id = us1.usu_id
				inner join documento_equipo 	de2 on de2.deq_id = a.deq_id_contratista
				inner join usuario 				us2 on de2.usu_id = us2.usu_id
				inner join documento_equipo 	de3 on de3.deq_id = a.deq_id_interventoria
				inner join usuario 				us3 on de3.usu_id = us3.usu_id
				inner join alcance_estado 		ae  on ae.ale_id  = a.ale_id
				where  ". $criterio ." order by ".$orden;

		//echo "getalcances".$sql;

		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$longitud = strlen($Contratistas);
				$Contratista = substr($Contratistas,0,$longitud);
				$alcance[$cont]['id'] 				= $w['alc_id'];
				$alcance[$cont]['nombre'] 			= $w['alc_nombre'];
				$alcance[$cont]['fecha_registro'] 	= $w['alc_fecha_registro'];
				$alcance[$cont]['contratante'] 		= $w['contratante'];
				$alcance[$cont]['contratista'] 		= $w['contratista'];
				$alcance[$cont]['interventoria'] 	= $w['interventoria'];
				$alcance[$cont]['reunion'] 			= $w['alc_reunion'];
				$alcance[$cont]['estado'] 			= $w['ale_nombre'];
				$cont++;
			}
		}
		return $alcance;
	}

	function getResponsables($criterio,$orden){
		$responsables = null;
		$sql = "select  de.deq_id, us.usu_nombre, us.usu_apellido from documento_actor da
				inner join documento_equipo de on da.doa_id = de.doa_id
				inner join usuario us on de.usu_id = us.usu_id
				inner join documento_tipo_actor ta on ta.dta_id=da.dta_id
				where ta.dta_id".$criterio."   order by ".$orden;

		//echo ("<br>getResponsablesAlcances:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$responsables[$cont]['id'] = $w['deq_id'];
				$responsables[$cont]['nombre'] = $w['usu_nombre'].' '.$w['usu_apellido'];
				$cont++;
			}
		}
		return $responsables;
	}

	function getEstados($criterio,$orden){
		$responsables = null;
		$sql = "select  * from alcance_estado
				where ".$criterio." order by ".$orden;
		//echo ("<br>getEstados:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$responsables[$cont]['id'] = $w['ale_id'];
				$responsables[$cont]['nombre'] = $w['ale_nombre'];
				$cont++;
			}
		}
		return $responsables;
	}



	function insertAlcance($nombre,$fecha_registro,$responsable_contratante,$responsable_contratista,$responsable_interventoria,$reunion,$estado,$observaciones,$registro,$operador){
		$tabla = "alcance";
		$campos = "alc_nombre,alc_fecha_registro,deq_id_contratante,deq_id_contratista,deq_id_interventoria,alc_reunion,ale_id,alc_observaciones,alc_registro,ope_id";
		$valores = "'".strtoupper($nombre)."','".$fecha_registro."',".$responsable_contratante.",".$responsable_contratista.",".$responsable_interventoria.",'".$reunion."',".$estado.",'".$observaciones."','".$registro."',".$operador;
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;


	}

	function updateAlcance($id,$nombre,$fecha_registro,$responsable_contratante,$responsable_contratista,$responsable_interventoria,$reunion,$estado,$observaciones,$registro){
		$tabla = "alcance";
		$campos = array('alc_nombre','alc_fecha_registro','deq_id_contratante','deq_id_contratista','deq_id_interventoria','alc_reunion','ale_id','alc_observaciones','alc_registro');
		$valores = array("'".strtoupper($nombre)."'","'".$fecha_registro."'","'".$responsable_contratante."'","'".$responsable_contratista."'","'".$responsable_interventoria."'","'".$reunion."'","'".$estado."'","'".$observaciones."'","'".$registro."'");

		$condicion = "alc_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}

	function deleteAlcance($id){
		//echo $id;
		$tabla = "alcance ";
		$predicado = "alc_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}

	function getAlcanceById($id){
		$opcion = null;
		$sql = "select a.alc_id, a.alc_nombre, a.alc_fecha_registro, a.deq_id_contratante,a.deq_id_contratista,a.deq_id_interventoria,a.alc_reunion,
						a.ale_id,a.alc_observaciones,a.alc_registro,a.ope_id
				from alcance a
				where alc_id= ". $id;
		//echo $sql;
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r){
			$opcion["id"] 				= $r["alc_id"];
			$opcion["nombre"] 			= $r["alc_nombre"];
			$opcion["fecha_registro"] 	= $r["alc_fecha_registro"];
			$opcion["contratante"] 		= $r["deq_id_contratante"];
			$opcion["contratista"] 		= $r["deq_id_contratista"];
			$opcion["interventoria"] 	= $r["deq_id_interventoria"];
			$opcion["reunion"] 			= $r["alc_reunion"];
			$opcion["estado"] 			= $r["ale_id"];
			$opcion["observaciones"] 	= $r["alc_observaciones"];
			$opcion["registro"]		 	= $r["alc_registro"];
			$opcion["operador"] 		= $r["ope_id"];

			return $opcion;
		}else{
			return -1;
		}
	}

	function getAlcanceSeeById($id){
		$opcion = null;
		$sql = "select a.alc_id, a.alc_nombre, a.alc_fecha_registro, a.deq_id_contratante,a.deq_id_contratista,a.deq_id_interventoria,a.alc_reunion,
						concat(us1.usu_nombre,' ',us1.usu_apellido) as contratante,
						concat(us2.usu_nombre,' ',us2.usu_apellido) as contratista,
						concat(us3.usu_nombre,' ',us3.usu_apellido) as interventoria,ae.ale_nombre,a.alc_observaciones,a.alc_registro
				from alcance a
				inner join documento_equipo 	de1 on de1.deq_id = a.deq_id_contratante
				inner join usuario 				us1 on de1.usu_id = us1.usu_id
				inner join documento_equipo 	de2 on de2.deq_id = a.deq_id_contratista
				inner join usuario 				us2 on de2.usu_id = us2.usu_id
				inner join documento_equipo 	de3 on de3.deq_id = a.deq_id_interventoria
				inner join usuario 				us3 on de3.usu_id = us3.usu_id
				inner join alcance_estado 		ae  on ae.ale_id  = a.ale_id
				where alc_id= ". $id;
		//echo $sql;
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r){
			$opcion["id"] 				= $r["alc_id"];
			$opcion["nombre"] 			= $r["alc_nombre"];
			$opcion["fecha_registro"] 	= $r["alc_fecha_registro"];
			$opcion["contratante"] 		= $r["contratante"];
			$opcion["contratista"] 		= $r["contratista"];
			$opcion["interventoria"] 	= $r["interventoria"];
			$opcion["reunion"] 			= $r["alc_reunion"];
			$opcion["estado"] 			= $r["ale_nombre"];
			$opcion["observaciones"] 	= $r["alc_observaciones"];
			$opcion["registro"] 		= $r["alc_registro"];
			$opcion["operador"] 		= "";
			return $opcion;
		}else{
			return -1;
		}
	}

	function getAlcanceIdByNombre($l){
		$pre = "alc_nombre = '". $l ."'";
		$r = $this->db->recuperarCampo('alcance','alc_id',$pre);
		if($r) return $r; else return -1;
	}

	function getCountAlcancesByNombre($var){
		$cont = $this->db->recuperarCampo('alcance','count(1)',"alc_nombre = '".$var."'");
		return $cont;
	}
}
?>
