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
* Clase Tabla
*
* @package  clases
* @subpackage aplicacion
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/
Class CTabla {

    var $dt = null;

    /**
     * * Constructor de la clase CTablaData
     * */
    function CTabla($dt) {
        $this->dt = $dt;
    }

    /**
     * * retorna un arreglo con las tablas pertenecientes a tablas basicas
     * */
    function getTablas() {
        $tablas['inventario_equipo']['id']='inventario_equipo';
        $tablas['inventario_equipo']['nombre']='Inventario (equipo)';

        $tablas['inventario_grupo']['id']='inventario_grupo';
        $tablas['inventario_grupo']['nombre']='Inventario (grupo)';

        $tablas['inventario_estado']['id']='inventario_estado';
        $tablas['inventario_estado']['nombre']='Inventario (estado)';

        $tablas['inventario_marca']['id']='inventario_marca';
        $tablas['inventario_marca']['nombre']='Inventario (marca)';

        $tablas['obligacion_clausula']['id']='obligacion_clausula';
        $tablas['obligacion_clausula']['nombre']='Obligacion (clausula)';

        $tablas['obligacion_componente']['id']='obligacion_componente';
        $tablas['obligacion_componente']['nombre']='Obligacion (componente)';

        $tablas['documento_tipo']['id']='documento_tipo';
        $tablas['documento_tipo']['nombre']='Documento (Tipo)';

    		$tablas['documento_tema']['id']='documento_tema';
    		$tablas['documento_tema']['nombre']='Documento (Tema)';

    		$tablas['documento_subtema']['id']='documento_subtema';
    		$tablas['documento_subtema']['nombre']='Documento (Subtema)';

    		$tablas['documento_estado']['id']='documento_estado';
    		$tablas['documento_estado']['nombre']='Documento (Estado)';

    		$tablas['documento_estado_respuesta']['id']='documento_estado_respuesta';
    		$tablas['documento_estado_respuesta']['nombre']='Documento (Estado Respuesta)';

    		$tablas['documento_actor']['id']='documento_actor';
    		$tablas['documento_actor']['nombre']='Documento (Responsables)';

    		$tablas['documento_tipo_actor']['id']='documento_tipo_actor';
    		$tablas['documento_tipo_actor']['nombre']='Documento (Tipo de Responsable)';

    		$tablas['riesgo_probabilidad']['id']='riesgo_probabilidad';
    		$tablas['riesgo_probabilidad']['nombre']='Riesgo (Probabilidad)';

    		$tablas['riesgo_categoria']['id']='riesgo_categoria';
    		$tablas['riesgo_categoria']['nombre']='Riesgo (Categoria)';

    		$tablas['riesgo_impacto']['id']='riesgo_impacto';
    		$tablas['riesgo_impacto']['nombre']='Riesgo (Impacto)';

    		$tablas['compromiso_estado']['id']='compromiso_estado';
    		$tablas['compromiso_estado']['nombre']='Compromisos (Estado)';

    		$tablas['departamento']['id']='departamento';
    		$tablas['departamento']['nombre']='Departamentos';

    		$tablas['departamento_region']['id']='departamento_region';
    		$tablas['departamento_region']['nombre']='Departamentos (Region)';

    		$tablas['municipio']['id']='municipio';
    		$tablas['municipio']['nombre']='Municipios';

        $tablas['operador']['id']='operador';
	      $tablas['operador']['nombre']='Operador';

        asort($tablas);
        return $tablas;
    }

    /**
     * * retorna un arreglo con los modos de las tablas pertenecientes a tablas basicas
     * */
    function getModos() {
        // arreglo para la determinacion del tipo de la tabla
        // 1 si se les puede agregar registros 0 si no se puede
        $modos['inventario_equipo']=1;
        $modos['inventario_estado']=1;
        $modos['inventario_grupo']=1;
        $modos['inventario_marca']=1;
        $modos['obligacion_clausula']=1;
        $modos['obligacion_componente']=1;
        $modos['documento_tipo']=1;
        $modos['documento_tema']=1;
        $modos['documento_subtema']=1;
        $modos['documento_estado']=1;
        $modos['documento_estado_respuesta']=1;
        $modos['documento_actor']=1;
        $modos['documento_tipo_actor']=1;
        $modos['riesgo_probabilidad']=1;
        $modos['riesgo_categoria']=1;
        $modos['riesgo_impacto']=1;
        $modos['compromiso_estado']=1;
        $modos['departamento']=0;
        $modos['departamento_region']=0;
        $modos['municipio']=0;
        $modos['operador']=0;
        return $modos;
    }

    /**
     * retorna un arreglo con los titulos para visualizacion de los campos de las tablas pertenecientes a tablas basicas
     */
    function getTitulos() {
        //arreglo para remplazar los titulos de las columnas
        $titulos_campos['ivg_id'] = INVENTARIO_GRUPO;
        $tirulos_campos['ivg_nombre'] = INVENTARIO_GRUPO;

        $titulos_campos['ine_id'] = INVENTARIO_EQUIPO;
        $titulos_campos['ine_nombre'] = INVENTARIO_NOMBRE_EQUIPO;
        $titulos_campos['ine_reposicion'] = INVENTARIO_EQUIPO_REPOSICION;

        $titulos_campos['ies_id'] = INVENTARIO_ESTADO;
        $titulos_campos['ies_nombre'] = INVENTARIO_NOMBRE_ESTADO;

        $titulos_campos['inm_id'] = INVENTARIO_MARCA;
        $titulos_campos['inm_nombre'] = INVENTARIO_MARCA;

        $tirulos_campos['obc_id'] = OBLIGACION_CLAUSULA;
        $tirulos_campos['obc_nombre'] = OBLIGACION_CLAUSULA;

        $tirulos_campos['oco_id'] = OBLIGACION_COMPONENTE;
        $tirulos_campos['oco_nombre'] = OBLIGACION_COMPONENTE;

        $titulos_campos['dti_id'] = DOCUMENTO_TIPO;
	      $titulos_campos['dti_nombre'] = DOCUMENTO_TIPO;
    		$titulos_campos['dti_estado'] = DOCUMENTO_ESTADO_CONTROL;
    		$titulos_campos['dti_responsable'] = DOCUMENTO_RESPONSABLE_CONTROL;

    		$titulos_campos['dot_id'] = DOCUMENTO_TEMA;
    		$titulos_campos['dot_nombre'] = DOCUMENTO_TEMA;

    		$titulos_campos['dos_id'] = DOCUMENTO_SUBTEMA;
    		$titulos_campos['dos_nombre'] = DOCUMENTO_SUBTEMA;

    		$titulos_campos['doa_id'] = DOCUMENTO_RESPONSABLE;
    		$titulos_campos['doa_nombre'] = DOCUMENTO_RESPONSABLE;
    		$titulos_campos['doa_sigla'] = DOCUMENTO_SIGLA;

    		$titulos_campos['tib_nombre'] = DOCUMENTO_BUSQUEDA;

    		$titulos_campos['doe_nombre'] = DOCUMENTO_ESTADOS;
    		$titulos_campos['der_nombre'] = DOCUMENTO_ESTADO_RESPUESTA;
    		$titulos_campos['see_nombre'] = SEGUIMIENTO_ESTADOS;
    		$titulos_campos['ces_nombre'] = COMPROMISO_ESTADOS;

    		$titulos_campos['dta_id'] = DOCUMENTO_TIPO_ACTOR;
    		$titulos_campos['dta_nombre'] = DOCUMENTO_TIPO_ACTOR;

    		$titulos_campos['rpr_nombre'] = PROBABILIDAD;
    		$titulos_campos['rpr_valor'] = PROBABILIDAD_VALOR;

    		$titulos_campos['rca_nombre'] = CATEGORIA;
    		$titulos_campos['rca_minimo'] = CATEGORIA_MINIMO;
    		$titulos_campos['rca_maximo'] = CATEGORIA_MAXIMO;

    		$titulos_campos['rim_nombre'] = IMPACTO;
    		$titulos_campos['rim_valor'] = IMPACTO_VALOR;

    		$titulos_campos['rer_id'] = COD_ROL;
    		$titulos_campos['rer_nombre'] = COD_ROL;

	      $titulos_campos['dep_id'] = COD_DEPARTAMENTO;
	      $titulos_campos['dep_nombre'] = NOMBRE_DEPARTAMENTO;

	      $titulos_campos['dpr_id'] = COD_DEPARTAMENTO_REGION;
	      $titulos_campos['dpr_nombre'] = NOMBRE_DEPARTAMENTO_REGION;

    		$titulos_campos['mun_id'] = COD_MUNICIPIO;
    		$titulos_campos['mun_nombre'] = NOMBRE_MUNICIPIO;
    		$titulos_campos['mun_poblacion'] = POB_MUNICIPIO;

        $titulos_campos['tia_nombre'] = TIPO_ACTOR;

        $titulos_campos['ope_id'] = OPERADOR;
        $titulos_campos['ope_nombre'] = OPERADOR_NOMBRE;
        $titulos_campos['ope_sigla'] = OPERADOR_SIGLA;
    		$titulos_campos['ope_contrato_no'] = OPERADOR_CONTRATO_NRO;
    		$titulos_campos['ope_contrato_valor'] = OPERADOR_CONTRATO_VALOR;

        return $titulos_campos;
    }

    /**
     * retorna un arreglo con las relaciones existentes entre las tablas pertenecientes a tablas basicas
     * esta relacion es usada para cargar ciertos campos de otras tablas cuanto estas tiene relacion
     * con la tabla basica que se esta editando
     */
    function getRelaciones() {
        //arreglo relacion de tablas
        //---------------------------->DEPARTAMENTO(OPERADOR)
        //---------------------------->TEMA(TIPO)
		$relacion_tablas['documento_tema']['dti_id']['tabla']='documento_tipo';
		$relacion_tablas['documento_tema']['dti_id']['campo']='dti_id';
		$relacion_tablas['documento_tema']['dti_id']['remplazo']='dti_nombre';
		//---------------------------->TEMA(TIPO)

		//---------------------------->SUBTEMA(TEMA)
		$relacion_tablas['documento_subtema']['dot_id']['tabla']='documento_tema';
		$relacion_tablas['documento_subtema']['dot_id']['campo']='dot_id';
		$relacion_tablas['documento_subtema']['dot_id']['remplazo']='dot_nombre';
        //---------------------------->SUBTEMA(TEMA)

        //---------------------------->DOCUMENTO(OPERADOR)
        $relacion_tablas['documento_actor']['ope_id']['tabla']='operador';
		$relacion_tablas['documento_actor']['ope_id']['campo']='ope_id';
		$relacion_tablas['documento_actor']['ope_id']['remplazo']='ope_nombre';
        //---------------------------->DOCUMENTO(TIPO DE ACTOR)
        $relacion_tablas['documento_actor']['dta_id']['tabla']='documento_tipo_actor';
		$relacion_tablas['documento_actor']['dta_id']['campo']='dta_id';
		$relacion_tablas['documento_actor']['dta_id']['remplazo']='dta_nombre';
        //----------------------------<DOCUMENTO

		//---------------------------->DEPARTAMENTO(OPERADOR)
		$relacion_tablas['departamento']['ope_id']['tabla']='operador';
		$relacion_tablas['departamento']['ope_id']['campo']='ope_id';
		$relacion_tablas['departamento']['ope_id']['remplazo']='ope_nombre';
		//---------------------------->DEPARTAMENTO(OPERADOR)

		//---------------------------->DEPARTAMENTO(REGION)
		$relacion_tablas['departamento']['dpr_id']['tabla']='departamento_region';
		$relacion_tablas['departamento']['dpr_id']['campo']='dpr_id';
		$relacion_tablas['departamento']['dpr_id']['remplazo']='dpr_nombre';
        //---------------------------->DEPARTAMENTO(REGION)

		//---------------------------->MUNICIPIO(DEPARTAMENTO)
		$relacion_tablas['municipio']['dep_id']['tabla']='departamento';
		$relacion_tablas['municipio']['dep_id']['campo']='dep_id';
		$relacion_tablas['municipio']['dep_id']['remplazo']='dep_nombre';
        //---------------------------->MUNICIPIO(DEPARTAMENTO)

        return $relacion_tablas;
    }

    /**
     * retorna un arreglo con los tipos de los campos de una tabla
     */
    function getTiposCampos($tabla) {
        $tipos = $this->dt->getTipos($tabla);
        return $tipos;
    }

    /**
     * retorna un arreglo con los opciones para seleccionar segun la relacion existente entre los campos de las tablas
     */
    function getOpciones($array) {
        $opciones = $this->dt->getOpciones($array['tabla'], $array['campo'], $array['remplazo']);
        return $opciones;
    }

    /**
     * * almacena un objeto TABLA y retorna un mensaje del resultado del proceso
     * */
    function saveNewTabla($tabla, $campos, $valores) {
        $r = $this->dt->saveNewTabla($tabla, $campos, $valores);
        if ($r == 'true') {
            $msg = TABLA_AGREGADA;
        } else {
            $msg = ERROR_ADD_TABLA;
        }

        return $msg;
    }

    /**
     * * actualiza un objeto TABLA y retorna un mensaje del resultado del proceso
     * */
    function saveEditTabla($tabla, $id_elemento, $campos, $valores) {
        $r = $this->dt->saveEditTabla($tabla, $id_elemento, $campos, $valores);
        if ($r == 'true') {
            $msg = TABLA_EDITADO;
        } else {
            $msg = ERROR_EDIT_TABLA;
        }

        return $msg;
    }

    function deleteTabla($tabla, $criterio){
        $r = $this->dt->deleteTabla($tabla,$criterio);
        if ($r == 'true') {
            $msg = TABLA_BORRADO;
        } else {
            $msg = ERROR_BORRADO_TABLA;
        }

        return $msg;
    }

}

?>
