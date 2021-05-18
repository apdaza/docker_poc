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
* Clase CompromisoData
* Usada para la definicion de todas las funciones propias del objeto COMPROMISO
*
* @package  clases
* @subpackage datos
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/
Class CCompromisoData{
    var $db = null;

	function CCompromisoData($db){
		$this->db = $db;
	}

	function getResponsablesCompromisos($criterio,$orden){
		$responsables = null;
		$sql = "SELECT  r.*
		FROM  documento_actor r INNER JOIN
		      operador p ON p.ope_id = r.ope_id
                WHERE  ". $criterio ."  order by ".$orden;
		//echo ("<br>getResponsablesCompromisos:".$sql);
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

	function getTemas($criterio,$orden){
		$tema = null;
		$sql = "SELECT tema.*
                        FROM  documento_tema AS tema INNER JOIN
                              documento_tipo AS tipo ON tema.dti_id = tipo.dti_id
			WHERE  ". $criterio ." order by ".$orden;
		//echo ("<br>getTemas:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$tema[$cont]['id'] = $w['dot_id'];
				$tema[$cont]['nombre'] = $w['dot_nombre'];
				$cont++;
			}
		}
		return $tema;
	}

	function getDocumentos($criterio,$orden){
		$subtema = null;
		$sql = "select doc_id, concat('Acta No.',doc_version) as document  from documento1
				where ". $criterio ." order by ".$orden;
		//echo ("<br>getDocumentos:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$subtema[$cont]['id'] = $w['doc_id'];
				$subtema[$cont]['nombre'] = $w['document'];
				$cont++;
			}
		}
		return $subtema;
	}

	function getEstadosCompromisos($criterio,$orden){
		$estados = null;
		$sql = "select * from compromiso_estado where ". $criterio ." order by ".$orden;
		//echo ("<br>getEstadosCompromisos:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$estados[$cont]['id'] = $w['ces_id'];
				$estados[$cont]['nombre'] = $w['ces_nombre'];
				$cont++;
			}
		}
		return $estados;
	}

	function getCompromisoById($id){
		$compromiso = null;
		$sql = "SELECT  *
			FROM  compromiso c
			WHERE com_id= ". $id ;
		//echo ("<br>getCompromisoById:".$sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}

	function getCompromisosSee($id){
		$sql = "SELECT c.com_id, c.com_actividad, dos.dos_id, dos_nombre, d.doc_id, d.doc_descripcion, c.com_fecha_limite,
                               c.com_fecha_entrega, te.ces_id, te.ces_nombre, c.com_observaciones,d.dot_id,d.dos_id
                        FROM compromiso c INNER JOIN
                             documento d on d.doc_id=c.doc_id INNER JOIN
                             documento_subtema dos on d.dos_id=dos.dos_id INNER JOIN
                             compromiso_estado te on te.ces_id = c.ces_id
                        WHERE  c.com_id=". $id;
		//echo ("<br>getCompromisosSee:".$sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}

	function getCompromisos($criterio,$orden,$dirOperador){
		$compromisos = null;
		$sql = "SELECT DISTINCT c.com_id, c.com_actividad, dti_nombre,dot_nombre,dos_nombre,doc_archivo,
                        d.doc_version, c.com_fecha_limite,
                        c.com_fecha_entrega, te.ces_nombre, c.com_observaciones
                        FROM compromiso c
						INNER JOIN documento d ON d.doc_id=c.doc_id
						inner join documento_tipo td on d.dti_id = td.dti_id
						inner join documento_tema tm on d.dot_id = tm.dot_id
						INNER JOIN documento_subtema dos ON d.dos_id=dos.dos_id
						INNER JOIN compromiso_estado te ON te.ces_id = c.ces_id
						LEFT  JOIN compromiso_responsable cr ON cr.com_id = c.com_id
						LEFT  JOIN documento_actor da ON da.doa_id = cr.doa_id
                        WHERE   ". $criterio ." ORDER  BY ".$orden;
		//echo ("<br>getCompromisos:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$responsables = '';
				$sql = "SELECT doa_nombre
						FROM documento_actor r  INNER JOIN
							 compromiso_responsable cr on r.doa_id=cr.doa_id INNER JOIN
							 compromiso c on cr.com_id=c.com_id
						WHERE cr.com_id=". $w['com_id'] ." order by doa_nombre";
				$rr = $this->db->ejecutarConsulta($sql);
				//echo ("<br>getCompromisos:".$sql);
				while($x = mysqli_fetch_array($rr)){
					$responsables .= $x['doa_nombre'].",";
				}
				$longitud = strlen($responsables)-1;
				$responsable = substr ($responsables,0,$longitud);
				$compromisos[$cont]['id'] = $w['com_id'];
				$compromisos[$cont]['dos_nombre'] = $w['dos_nombre'];
				$compromisos[$cont]['doa_nombre'] = $responsable;
				$compromisos[$cont]['com_actividad'] = $w['com_actividad'];
				$compromisos[$cont]['doc_referencia'] = 'Acta No. '."<a href='././soportes/".strtolower($dirOperador.$w['dti_nombre']."/".$w['dot_nombre']."/").$w['doc_archivo']."' target='_blank'>{$w['doc_version']}</a>";;
				$compromisos[$cont]['com_fecha_limite'] = $w['com_fecha_limite'];
				$compromisos[$cont]['ces_nombre'] = $w['ces_nombre'];
				$compromisos[$cont]['com_fecha_entrega'] = $w['com_fecha_entrega'];
				$compromisos[$cont]['com_observaciones'] = $w['com_observaciones'];
				$cont++;
			}
		}
		return $compromisos;
	}

	function getReferenciasDocumentos($criterio,$orden){
		$referencias = null;
		$sql = "SELECT *
                        FROM   documento d INNER JOIN
                               documento_tipo AS tipo ON d.dti_id = tipo.dti_id INNER JOIN
                               documento_subtema 	ds on ds.dos_id=d.dos_id
                        WHERE  ". $criterio ." ORDER BY ".$orden;
		//echo ("<br>getReferenciasDocumentos:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$referencias[$cont]['id'] = $w['doc_id'];
				$referencias[$cont]['nombre'] = $w['dos_nombre'].'-'.'Acta No. '.$w['doc_version'];
				$cont++;
			}
		}
		return $referencias;
	}

	function insertCompromiso($actividad,$referencia,$fecha_limite,$fecha_entrega,$estado,$observaciones,$operador){

		$tabla = "compromiso";
		$campos = "com_actividad,doc_id,com_fecha_limite,com_fecha_entrega,ces_id,com_observaciones,ope_id";
		$valores = "'".$actividad."','".$referencia."','".$fecha_limite."','".$fecha_entrega."','".$estado."','".$observaciones."','".$operador."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}

	function deleteCompromiso($id){
		$tabla = "compromiso_responsable";
		$predicado = "com_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		if($r=='true'){
			$tabla = "compromiso";
			$predicado = "com_id = ". $id;
			$r = $this->db->borrarRegistro($tabla,$predicado);
			if($r=='true')	return "true"; else return "false";
		}
		else return "false";
	}

	function updateCompromiso($id,$actividad,$referencia,$fecha_limite,$fecha_entrega,$estado,$observaciones){

		$tabla = "compromiso";
		$campos = array('com_actividad','doc_id','com_fecha_limite', 'com_fecha_entrega','ces_id', 'com_observaciones');
		$valores = array("'".$actividad."'","'".$referencia."'","'".$fecha_limite."'","'".$fecha_entrega."'",$estado,"'".$observaciones."'");
		$condicion = "com_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}

	function updateResponsables($id,$responsables){

		$tabla = "compromiso1";
		$campos = array('doa_id_otros');
		$valores = array("'".$responsables."'");

		$condicion = "com_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}
	function getResponsables($criterio,$orden){
		$responsables = null;
		$sql = "SELECT cr.cor_id, cr.com_id,r.doa_nombre,c.com_actividad
                        FROM compromiso_responsable cr INNER JOIN
                                 compromiso c on cr.com_id = c.com_id INNER JOIN
                                 documento_actor r on cr.doa_id =r.doa_id
			WHERE ". $criterio."
			ORDER  BY ".$orden;

		//echo ("<br>getResponsables:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$responsables[$cont]['id'] = $w['cor_id'];
				$responsables[$cont]['com_id'] = $w['com_id'];
				$responsables[$cont]['nombre'] = $w['doa_nombre'];
				$responsables[$cont]['actividad'] = $w['com_actividad'];
				$cont++;
			}
		}
		return $responsables;
	}

	function deleteResumen(){
		$tabla = "compromiso_resumen";
		$predicado = " 1";
		$n = $this->db->borrarRegistro($tabla,$predicado);
		return $n;

	}

	function insertResumen($responsable,$abierto,$cerrado,$cancelado,$operador){
		$tabla = "compromiso_resumen";
		$campos = "cor_nombre_tmp,ces_1,ces_2,ces_3,ope_id";
		$valores = "'".$responsable."',".$abierto.",".$cerrado.",".$cancelado.",".$operador;
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}

	function updateResumen($responsable,$abierto,$cerrado,$cancelado,$operador){
		$tabla = "compromiso_resumen";
		$campos = array('ces_1', 'ces_2', 'ces_3','ope_id');
		$valores = array($abierto,$cerrado,$cancelado,$operador);

		$condicion = "cor_nombre_tmp = '".$responsable."'";
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}

	function getResumen($responsable,$operador){

		$sql = "select *
				from compromiso_resumen
				where cor_nombre_tmp= '". $responsable."' and ope_id=".$operador ;
		//echo ("<br>getResumen:".$sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}


	function getResumenes($operador){
		$resumenes = null;
		$sql = "select cor_nombre_tmp, ces_1, ces_2, ces_3
				from compromiso_resumen
				where ope_id = ".$operador."
				order by cor_nombre_tmp";

		//echo ("<br>getResumenes:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysqli_fetch_array($r)){
				$resumenes[$cont]['id'] = $cont;
				$resumenes[$cont]['cor_nombre_tmp'] = $w['cor_nombre_tmp'];
				$resumenes[$cont]['ces_1'] = $w['ces_1'];
                    		$resumenes[$cont]['ces_2'] = $w['ces_2'];
				$resumenes[$cont]['ces_3'] = $w['ces_3'];
				$cont++;
			}
		}
		return $resumenes;
	}
}
