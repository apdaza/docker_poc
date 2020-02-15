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
* Language Riesgos
*
* @package  clases
* @subpackage lang
* @author Alejandro Daza
* @version 2019.02
* @copyright apdaza
*/
	define('TABLA_RIESGOS','Riesgos');
	define('TABLA_ACCIONES','Acciones');
	define('LISTAR_RIESGOS','Listar Riesgos');
	define('LISTAR_ACCIONES','Listar Acciones');
	define('AGREGAR_RIESGOS','Agregar Riesgos');
	define('EDITAR_RIESGOS','Editar Riesgos');
	define('PROBABILIDAD_VALOR','Valor');
	define('IMPACTO_VALOR','Valor');

	define('ERROR_ACCIONES_FECHA','**Debe ingresar la fecha');
	define('ERROR_ACCIONES_DESCRIPCION','**Debe ingresar la descripcion de la accion');
	define('ERROR_RIESGOS_DESCRIPCION','**Debe ingresar la descripcion del riesgo');
	define('ERROR_RIESGOS_ALCANCE','**Debe seleccionar un alcance');
	define('ERROR_RIESGOS_IMPACTO','**Debe seleccionar el impacto del riesgo');
	define('ERROR_ACCION_RESPONSABLE','**Debe seleccionar el responsable');
	define('ERROR_RIESGOS_PROBABILIDAD','**Debe seleccionar la probabilidad del riesgo');
	define('ERROR_RIESGOS_ACCION','**Debe seleccionar las Acciones');
	define('ERROR_RIESGOS_FECHA_DETEC','**Debe ingresar la fecha de la deteccion');
	define('ERROR_RIESGOS_FECHA_ACCION','**Debe ingresar la fecha de la accion');
	define('ERROR_RIESGOS_FECHA_ENTREGA','**Debe ingresar la fecha de entrega');
	define('ERROR_RIESGOS_CATEGORIA','**Debe seleccionar la categoria resultante');
	define('ERROR_RIESGOS_ESTADO','**Debe seleccionar el estado');
	define('ERROR_RIESGOS_OBSERVACIONES','**Debe ingresar las observaciones');
	define('ERROR_RIESGOS_ESTRATEGIA','**Debe ingresar la estrategia');

	define('ACCIONES_FECHA','Fecha de la accion');
	define('ACCIONES_DESCRIPCION','Descripcion de la accion');
	define('RIESGOS_DESCRIPCION','Descripcion');
	define('RIESGOS_ALCANCE','Alcance');
	define('RIESGOS_IMPACTO','Impacto');
	define('RIESGOS_RESPONSABLE','Responsable');
	define('RIESGOS_PROBABILIDAD','Probabilidad');
	define('RIESGOS_ACCION','Primera accion unicamente');
	define('RIESGOS_FECHA_ACTUA','Fecha de Actualizacion');
	define('RIESGOS_FECHA_DETEC','Fecha de Deteccion');
	define('RIESGOS_FECHA_ENTREGA','Fecha de entrega');
	define('RIESGOS_CATEGORIA','Categoria');
	define('RIESGOS_ESTADO','Estado');
	define('RIESGOS_OBSERVACIONES','Observaciones');
	define('RIESGOS_ESTRATEGIA','Estrategia');
	define('CATEGORIA_MINIMO','Mínimo');
	define('CATEGORIA_MAXIMO','Máximo');

	define('RIESGO_AGREGADO','El riesgo ha sido agregado con exito');
	define('ERROR_ADD_RIESGO','No se ha podido agregar el riesgo');
	define('RIESGO_EDITADO','El riesgo ha sido actualizado con exito');
	define('ERROR_EDIT_RIESGO','No se ha podido actualizar el riesgo');
	define('RIESGO_BORRADO','El riesgo ha sido eliminado con exito');
	define('ERROR_DEL_RIESGO','No se ha podido eliminar el riesgo');
	define('RIESGO_MSG_BORRADO','Esta seguro que desea eliminar el riesgo?');

	define('ACCION_EDITADO','La accion ha sido actualizada con exito');
	define('ERROR_EDIT_ACCION','No se ha podido actualizar la accion');
	define('ACCION_AGREGADO','La accion ha sido agregada con exito');
	define('ERROR_ADD_ACCION','Error al agregar la accion<br>Verifique que no se repita la fecha de la accion');
	define('ACCION_BORRADO','La accion ha sido eliminada con exito');
	define('ERROR_DEL_ACCION','No se ha podido eliminar la accion');
	define('ACCION_MSG_BORRADO','Esta seguro que desea eliminar la accion?');

	define('RIESGOS_INICIADO','Iniciados');
	define('RIESGOS_REALIZADO','Realizados');
	define('RIESGOS_EN_PROCESO','En Proceso');
	define('RIESGOS_CERRADO','Cerrados');
	define('RIESGOS_CANCELADO','Cancelados');
	define('RIESGOS_ATRASADO','Atrasados');

	define('VALOR_IMPACTO','Impacto');
	define('VALOR_PROBABILIDAD','Probabilidad');
	define('VALOR_CATEGORIA','Categoria');
	define('VALOR_MITIGACION','% Mitigacion');
	?>
