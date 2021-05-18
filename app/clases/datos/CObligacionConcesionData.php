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
* Clase CObligacionConcesionData
* Usada para la definicion de todas las funciones propias del objeto OBLIGACION
*
* @package  clases
* @subpackage datos
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/
Class CObligacionConcesionData{
    var $db = null;

	function CObligacionConcesionData($db){
		$this->db = $db;
	}

	function getObligaciones($criterio,$orden,$anio){
		$salida = null;
		$sql = "select *
				from obligacion_concesion    ocs
				inner join obligacion_componente    oco on oco.oco_id=ocs.oco_id
				inner join obligacion_periodicidad  obp on obp.obp_id=ocs.obp_id
				where ". $criterio." order by ".$orden;
		//echo("<br>".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 			= $w['ocs_id'];
				$salida[$cont]['componente'] 	= $w['oco_nombre'];
				$salida[$cont]['literal'] 		= $w['ocs_literal'];
				$salida[$cont]['descripcion'] 	= $w['ocs_descripcion'];
				$oblig_int=null;
				$sql1 = "select obi_literal FROM  obligacion_conc_int oci
						inner join obligacion_interventoria obi on obi.obi_id=oci.obi_id
						where oci.ocs_id=". $w['ocs_id'] ." order by obi.obi_literal";
				//echo("<br>".$sql1);
				$x = $this->db->ejecutarConsulta($sql1);
				if($x){
					$cont1 = 0;
					while($z = mysqli_fetch_array($x)){
						$oblig_int = $oblig_int."<br>".$z['obi_literal'];
						$cont1++;
					}
				}
				$salida[$cont]['obligacion'] 	= $oblig_int;
				$salida[$cont]['periodicidad'] 	= $w['obp_nombre'];
				$salida[$cont]['criterio'] 		= $w['ocs_criterio'];
				if ($anio==2014)
					for($i=3;$i<=12;$i++){
						$pre = "oct.obe_id=obe.obe_id and oct_anio = '". $anio ."' and oct_mes=".$i." and ocs_id=".$w['ocs_id'];
						$estado = $this->db->recuperarCampo('obligacion_concesion_traza oct, obligacion_estado obe','obe_nombre',$pre);
						$salida[$cont][$i] = $estado;
					}
				else
					for($i=1;$i<=12;$i++){
						$pre = "oct.obe_id=obe.obe_id and oct_anio = '". $anio ."' and oct_mes=".$i." and ocs_id=".$w['ocs_id'];
						$estado = $this->db->recuperarCampo('obligacion_concesion_traza oct, obligacion_estado obe','obe_nombre',$pre);
						$salida[$cont][$i] = $estado;
					}
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
	function getAniosObligacion($criterio,$orden){
		$salida = null;
		$sql = "select distinct oct_anio, oba_anio
				FROM  obligacion_concesion_traza
        INNER JOIN obligacion_anio on oct_anio = oba_id
				where ". $criterio ." order by ".$orden;
				//echo($sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 	 = $w['oct_anio'];
				$salida[$cont]['nombre'] = $w['oba_anio'];
				$cont++;
			}
		}
		return $salida;
	}
	function getAnios($criterio,$orden){
		$salida = null;
		$sql = "select *
				FROM  obligacion_anio
				where ". $criterio ." order by ".$orden;
				//echo($sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 	 = $w['oba_id'];
				$salida[$cont]['nombre'] = $w['oba_anio'];
				$cont++;
			}
		}
		return $salida;
	}
	function getMeses($criterio,$orden,$anio,$obligacion){
		$salida = null;
		$sql = "select *
				FROM  obligacion_mes
				where obm_id not in (select distinct oct_mes FROM  obligacion_concesion_traza where oct_anio=".$anio." and ocs_id=".$obligacion.") order by ".$orden;
		//echo("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 	 = $w['obm_id'];
				$salida[$cont]['nombre'] = $w['obm_mes'];
				$cont++;
			}
		}
		return $salida;
	}
	function getMesesTotal(){
		$salida = null;
		$sql = "select *
				FROM  obligacion_mes
				where 1 order by obm_id";
				//echo($sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 	 = $w['obm_id'];
				$salida[$cont]['nombre'] = $w['obm_mes'];
				$cont++;
			}
		}
		return $salida;
	}
	function getEstados($criterio,$orden){
		$salida = null;
		$sql = "select *
				FROM  obligacion_estado
				where ". $criterio ." order by ".$orden;
				//echo($sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 	 = $w['obe_id'];
				$salida[$cont]['nombre'] = $w['obe_nombre'];
				$cont++;
			}
		}
		return $salida;
	}
	function getPeriodicidades($criterio,$orden){
		$salida = null;
		$sql = "select *
				FROM  obligacion_periodicidad
				where ". $criterio ." order by ".$orden;
				//echo($sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 	 = $w['obp_id'];
				$salida[$cont]['nombre'] = $w['obp_nombre'];
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
	function insertObligacion($componente,$clausula,$literal,$descripcion,$periodicidad,$criterio){
		$tabla = "obligacion_concesion";
		$campos = "oco_id,obc_id,ocs_literal,ocs_descripcion,obp_id,ocs_criterio";
		$valores = "'".$componente."','".$clausula."','".$literal."','".$descripcion."','".$periodicidad."','".$criterio."'";

		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	function deleteObligacion($id){
		//echo $id;
		$tabla = "obligacion_concesion ";
		$predicado = "ocs_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	function updateObligacion($id,$componente,$clausula,$literal,$descripcion,$periodicidad,$criterio){
		$tabla = "obligacion_concesion";
		$campos = array('oco_id','obc_id','ocs_literal','ocs_descripcion','obp_id','ocs_criterio');
		$valores = array("'".$componente."'","'".$clausula."'","'".$literal."'","'".$descripcion."'","'".$periodicidad."'","'".$criterio."'");

		$condicion = "ocs_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
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

	function getObligacionIdByDescripcion($l){
		$pre = "ocs_descripcion = '". $l ."'";
		$r = $this->db->recuperarCampo('obligacion_concesion','ocs_id',$pre);
		if($r) return $r; else return -1;
	}
	function getObligacionId($l){
		$pre = "ocs_id = '". $l ."'";
		$r = $this->db->recuperarCampo('obligacion_concesion','ocs_descripcion',$pre);
		if($r) return $r; else return -1;
	}
	function getObligacionNombre($id){
		$pre = "ocs_id = '". $id ."'";
		$r = $this->db->recuperarCampo("obligacion_concesion","SUBSTRING(concat(ocs_literal,'-',ocs_descripcion),1,100)",$pre);
		if($r) return $r; else return -1;
	}

	// funciones especificas para gestionar los soportes de un caso de uso

	function getDirectorioOperador($id){
		$tabla='operador';
		$campo='ope_sigla';
		$predicado='ope_id = '. $id;
		if(!isset($id) || $id=="")
		   $predicado='ope_id=1';
		$r = $this->db->recuperarCampo($tabla,$campo,$predicado);
		$r = $r."/";
		if($r) return $r; else return -1;
	}
	function getObligacionTrazas($criterio,$operador){
		$salida = null;
		$sql = "select * from obligacion_concesion_traza oct
				inner join obligacion_estado obe on obe.obe_id=oct.obe_id where ". $criterio ;
		//echo($sql);
		$r = $this->db->ejecutarConsulta($sql);
		$dirOperador=$this->getDirectorioOperador($operador);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$salida[$cont]['id'] 				= $w['oct_id'];
				if ($w['oct_mes']==1) $mes="Ene";
				elseif ($w['oct_mes']==2) $mes="Feb";
				elseif ($w['oct_mes']==3) $mes="Mar";
				elseif ($w['oct_mes']==4) $mes="Abr";
				elseif ($w['oct_mes']==5) $mes="May";
				elseif ($w['oct_mes']==6) $mes="Jun";
				elseif ($w['oct_mes']==7) $mes="Jul";
				elseif ($w['oct_mes']==8) $mes="Ago";
				elseif ($w['oct_mes']==9) $mes="Sep";
				elseif ($w['oct_mes']==10) $mes="Oct";
				elseif ($w['oct_mes']==11) $mes="Nov";
				elseif ($w['oct_mes']==12) $mes="Dic";
				$salida[$cont]['fecha'] 			= $w['oct_anio']."-".$mes;
				$salida[$cont]['estado'] 			= $w['obe_nombre'];
				$salida[$cont]['evidencia'] 		= $w['oct_evidencia'];
				$salida[$cont]['gestion'] 			= $w['oct_gestion'];
				$salida[$cont]['recomendaciones'] 	= $w['oct_recomendacion'];
				$salida[$cont]['soporte'] 			= "<a href='././soportes/".$dirOperador."obligaciones/".$w['oct_archivo']."' target='_blank'>{$w['oct_archivo']}</a>";
				$cont++;
			}
		}
		return $salida;
	}
	function insertObligacionTraza($obligacion,$anio,$mes,$estado,$evidencia,$gestion,$recomendacion,$archivo){
		$tabla = "obligacion_concesion_traza";
		$campos = "ocs_id,oct_anio,oct_mes,obe_id,oct_evidencia,oct_gestion,oct_recomendacion,oct_archivo";
		$valores = "'".$obligacion."','".$anio."','".$mes."','".$estado."','".$evidencia."','".$gestion."','".$recomendacion."','".$archivo."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}

	function deleteObligacionTraza($id){
		$tabla = "obligacion_concesion_traza";
		$predicado = "oct_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	function getObligacionTrazaById($id){
		$sql = "select *
				from obligacion_concesion_traza
				WHERE oct_id=". $id;
		//echo ("<br>getObligacionTrazaById:".$sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}
	function updateObligacionTrazaArchivo($id,$obligacion,$anio,$mes,$estado,$evidencia,$gestion,$recomendacion,$archivo){
		$tabla = "obligacion_concesion_traza";
		$campos = array('ocs_id','oct_anio','oct_mes','obe_id','oct_evidencia','oct_gestion','oct_recomendacion','oct_archivo');
		$valores = array("'".$obligacion."'","'".$anio."'","'".$mes."'","'".$estado."'","'".$evidencia."'","'".$gestion."'","'".$recomendacion."'","'".$archivo."'");
		$condicion = "oct_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}
	function updateObligacionTraza($id,$obligacion,$anio,$mes,$estado,$evidencia,$gestion,$recomendacion){
		$tabla = "obligacion_concesion_traza";
		$campos = array('ocs_id','oct_anio','oct_mes','obe_id','oct_evidencia','oct_gestion','oct_recomendacion');
		$valores = array("'".$obligacion."'","'".$anio."'","'".$mes."'","'".$estado."'","'".$evidencia."'","'".$gestion."'","'".$recomendacion."'");
		$condicion = "oct_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}

}
?>
