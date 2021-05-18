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
* Clase RiesgoData
* Usada para la definicion de todas las funciones propias del objeto RIESGO
*
* @package  clases
* @subpackage datos
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/
Class CRiesgoData{
    var $db = null;
	
	function CRiesgoData($db){
		$this->db = $db;
	}

	function getResponsablesRiesgos($criterio,$orden){
		$responsables = null;
		$sql = "select r.* from documento_actor r where ". $criterio ."  order by ".$orden;
		//echo ("getResponsablesRiesgos:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$responsables[$cont]['id'] = $w['doa_id'];
				$responsables[$cont]['nombre'] = $w['doa_nombre'];
				$cont++;
			}
		}
		return $responsables;
	}
			
	function getAlcances($criterio,$orden){
		$alcances = null;
		$sql = "select * from alcance where alc_id > 0 and ". $criterio ." order by ".$orden;
		//echo ("<br>getAlcances:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$alcances[$cont]['id'] = $w['alc_id'];
				$alcances[$cont]['nombre'] = $w['alc_nombre'];
				$cont++;
			}
		}
		//echo ("<br>getAlcances:".$sql);
		return $alcances;
	}
	
	function getCategoriasRiesgos($criterio,$orden){
		$riesgo_categoria = null;
		$sql = "select * from riesgo_categoria where rca_id > 0 and ". $criterio ." order by ".$orden;
		//echo ("<br>getCategoriasRiesgos:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$riesgo_categoria[$cont]['id'] = $w['rca_id'];
				$riesgo_categoria[$cont]['nombre'] = $w['rca_nombre'];
				$cont++;
			}
		}
		return $riesgo_categoria;
	}
	function getRiesgoAccion($criterio,$orden){
		$riesgo_accion = null;
		$sql = "select count(rie_id) as valor, rie_id from riesgo_accion where ". $criterio. " group by rie_id";
		$r = $this->db->ejecutarConsulta($sql);	
		if($r){
			$contador = 1;
		while($w = mysqli_fetch_array($r)){
			$contador =$w['valor']+1;
			$riesgo_accion[$contador]['id'] = $w['rie_id'];
			$riesgo_accion[$contador]['valor'] = $contador;
			}
		}
	return $riesgo_accion;
	}
	
	function getCategoriasCalculado($riesgo_impacto,$riesgo_probabilidad){
		$riesgo_categoria = null;
		$sql = "select ca.rca_id,ca.rca_nombre,im.rim_valor,pr.rpr_valor from riesgo_impacto im,
				riesgo_probabilidad pr, riesgo_categoria ca where 
				im.rim_id=".$riesgo_impacto." and pr.rpr_id=".$riesgo_probabilidad." and (im.rim_valor*pr.rpr_valor) between ca.rca_minimo and ca.rca_maximo limit 0,1";
		//echo ("<br>getCategoriasRiesgos:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
			$probabilidad =$w['rpr_valor'];	
			$impacto=$w['rim_valor'];
			$categoria = $impacto*$probabilidad;
			$riesgo_categoria[$cont]['id'] = $w['rca_id'];
			$riesgo_categoria[$cont]['nombre'] = $w['rca_nombre'];
			$riesgo_categoria[$cont]['valor'] = $categoria;
			$cont++;
			}
		}
		return $riesgo_categoria;
	}

	function getRiesgoByCriterio($criterio){
		$tabla = "riesgo";
		$campos = "rie_id";
		$r = $this->db->recuperarCampo($tabla,$campos,$criterio);
		//echo ("<br>r:".$r);
		if($r) return $r; else return -1;
	}

	function getRiesgoById($id){
		$riesgo = null;
		$sql = "select *
				from riesgo r
				where  r.rie_id=". $id;
		//echo ("<br>getRiesgoById:".$sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}

	function getRiesgos($criterio,$orden){
		$riesgos = null;
		$sql = "SELECT  r.rie_id, r.rie_descripcion, r.rie_estrategia, r.rie_fecha_deteccion, 
						im.rim_nombre,im.rim_valor, pr.rpr_nombre,pr.rpr_valor, ca.rca_nombre, 
						r.rie_fecha_actualizacion, es.res_nombre
				FROM riesgo r
				INNER JOIN alcance              a ON a.alc_id  = r.alc_id
				INNER JOIN riesgo_impacto      im ON im.rim_id = r.rim_id
				INNER JOIN riesgo_probabilidad pr ON pr.rpr_id = r.rpr_id
				INNER JOIN riesgo_categoria    ca ON ca.rca_id = r.rca_id
				INNER JOIN riesgo_estado       es ON es.res_id = r.res_id
				WHERE ".$criterio ." order by ".$orden;
				//echo ("<br>getRiesgos:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$responsables = '';			
				$sql = "select doa_nombre from documento_actor r 
				inner join riesgo_responsable cr on r.doa_id=cr.doa_id
				inner join riesgo c on cr.rie_id=c.rie_id
				where cr.rie_id=". $w['rie_id'] ." order by doa_nombre";
				$rr = $this->db->ejecutarConsulta($sql);
				while($x = mysqli_fetch_array($rr)){
					$responsables .= $x['doa_nombre'].",";	
				}
				$longitud = strlen($responsables)-1;
				$responsable = substr ($responsables,0,$longitud); 
				$riesgos[$cont]['id'] = $w['rie_id'];
				$riesgos[$cont]['rie_descripcion'] = $w['rie_descripcion'];
				$tabla = "riesgo_accion";
				$campos = "rac_descripcion";
				$criterio = "rie_id=".$w['rie_id']." order by rac_fecha desc limit 1";
				$zz = $this->db->recuperarCampo($tabla,$campos,$criterio);
				$riesgos[$cont]['rie_estrategia'] = $w['rie_estrategia']."<br><b><u>".$zz."</u></b>";
				$riesgos[$cont]['rie_fecha_deteccion'] = $w['rie_fecha_deteccion'];
				$riesgos[$cont]['rie_fecha_actualizacion'] = $w['rie_fecha_actualizacion'];
				$riesgos[$cont]['doa_nombre'] = $responsable;
				$riesgos[$cont]['rim_nombre'] = $w['rim_nombre'];
				//$riesgos[$cont]['rim_valor'] = $prueba1;
				$riesgos[$cont]['rpr_nombre'] = $w['rpr_nombre'];
				//$riesgos[$cont]['rpr_valor'] = $prueba;
				$riesgos[$cont]['rca_nombre'] = $w['rca_nombre'];
				$riesgos[$cont]['res_nombre'] = $w['res_nombre'];
				//$riesgos[$cont]['rca_valor'] = $prueba2;
				$cont++;
			}
		}
		//echo ("<br>getCompromisos:".$riesgos[$cont-2]['rie_fecha_deteccion']);
		return $riesgos;
	}
	
	function getImpacto($criterio,$orden){
		$referencias = null;
		$sql = "select * from riesgo_impacto where rim_id > 0 and ". $criterio ." order by ".$orden;
		//echo ("<br>getImpacto:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$referencias[$cont]['id'] = $w['rim_id'];
				$referencias[$cont]['nombre'] = $w['rim_nombre'];
				$cont++;
			}
		}
		return $referencias;
	}	
	
	function getProbabilidad($criterio,$orden){
		$referencias = null;
		$sql = "select * from riesgo_probabilidad where rpr_id > 0 and ". $criterio ." order by ".$orden;
		//echo ("<br>getProbabilidad:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$referencias[$cont]['id'] = $w['rpr_id'];
				$referencias[$cont]['nombre'] = $w['rpr_nombre'];
				$cont++;
			}
		}
		return $referencias;
	}
	
	function getEstados($criterio,$orden){
		$referencias = null;
		$sql = "select * from riesgo_estado where ". $criterio ." order by ".$orden;
		//echo ("<br>getEstados:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$referencias[$cont]['id'] = $w['res_id'];
				$referencias[$cont]['nombre'] = $w['res_nombre'];
				$cont++;
			}
		}
		return $referencias;
	}	
	function insertRiesgo($descripcion,$fecha_accion,$estrategia,$impacto,$probabilidad,$categoria,$alcance,$estado){
		$id = $this->getid();
        $tabla = "riesgo";
        $campos = "rie_id,rie_descripcion,rie_fecha_deteccion,rie_estrategia,rim_id,rpr_id,rca_id,alc_id,res_id";
        $valores = "'" .$id ."','" . $descripcion . "','" . $fecha_accion . "','" . $estrategia . "','" . $impacto . "','" . $probabilidad . "','" . $categoria . "','" . $alcance . "','" . $estado . "'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}

	
	function deleteRiesgo($id){
		$tabla = "riesgo";
		$predicado = "rie_id = ". $id;
		$r1 = $this->db->borrarRegistro($tabla,$predicado);
		$tabla = "riesgo_responsable";
		$predicado = "rie_id = ". $id;
		$r2 = $this->db->borrarRegistro($tabla,$predicado);
		$tabla = "riesgo_accion";
		$predicado = "rie_id = ". $id;
		$r3 = $this->db->borrarRegistro($tabla,$predicado);
		if($r1=='true')	return "true"; else return "false";
	}
		
	function updateRiesgo($id,$descripcion,$fecha_accion,$estrategia,$riesgo_impacto,$riesgo_probabilidad,$categoria,$alcance,$estado){
		$tabla = "riesgo";
		$campos = array('rie_descripcion', 'rie_fecha_deteccion', 'rie_estrategia', 'alc_id', 'res_id');
		$valores = array("'".$descripcion."'","'".$fecha_accion."'",
							"'".$estrategia."'","'".$alcance."'","'".$estado."'");			
		$condicion = "rie_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}
	
	function getResponsables($criterio,$orden){
		$responsables = null;
		$sql = "select cr.rir_id, cr.rie_id,
					   r.doa_nombre,
					   c.rie_descripcion
				from riesgo_responsable cr
				inner join riesgo c on cr.rie_id = c.rie_id
				inner join documento_actor r on cr.doa_id =r.doa_id
				where ". $criterio." 
				order by ".$orden;	
				
		//echo ("<br>getResponsables:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$responsables[$cont]['id'] = $w['rir_id'];
				$responsables[$cont]['rie_id'] = $w['rie_id'];
				$responsables[$cont]['nombre'] = $w['doa_nombre'];
				$responsables[$cont]['descripcion'] = $w['rie_descripcion'];
				$cont++;
			}
		}
		return $responsables;
	}
	
	function getResponsablesEquipo($criterio,$orden){
		$responsables = null;
		$sql = "select u.usu_id, u.usu_nombre,u.usu_apellido
				from documento_actor r
				inner join documento_equipo de on r.doa_id = de.doa_id
				inner join usuario u on de.usu_id =u.usu_id
				where ". $criterio." 
				order by ".$orden;	
				
		//echo ("<br>getResponsables:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$responsables[$cont]['usu_id'] = $w['usu_id'];
				$responsables[$cont]['nombre'] = $w['usu_nombre'].' '.$w['usu_apellido'];;
				$cont++;
			}
		}
		return $responsables;
	}
	
	 function getId() {
        $sql = "SELECT max(rie_id)+1 AS columnas , rie_id  FROM riesgo";
        $r = $this->db->ejecutarConsulta($sql);
        $id = 0;
        if ($r)
        {
            $datos = mysqli_fetch_array($r);
            $id = $datos['columnas'];
        }
        return $id;
    }
}