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
* Language Documentos
*
* @package  clases
* @subpackage lang
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/
	define('TABLA_DOCUMENTOS','Documentos');
	define('TABLA_RESUMEN_DOCUMENTOS','Resumen de Documentos');
	define('TABLA_OTROS_DOCUMENTOS','Otros Documentos');
	define('LISTAR_DOCUMENTOS','Listar Documentos');
	define('LISTAR_ALARMAS','Listar Seguimientos');
	define('AGREGAR_DOCUMENTOS','Agregar Documentos');
	define('AGREGAR_EQUIPO','Agregar Miembro al Equipo de Trabajo');
	define('EDITAR_DOCUMENTOS','Editar documento');
	define('EXCEL_DOCUMENTOS','Descarga en Excel el listado de actas gestionadas');

	define('DOCUMENTO_FECHA_INICIO_BUSCAR','Fecha inicial');
	define('DOCUMENTO_FECHA_FIN_BUSCAR','Fecha final');

	define('DOCUMENTO_ESTADO_CONTROL','Controla estado');
	define('DOCUMENTO_RESPONSABLE_CONTROL','Controla responsable');
	define('DOCUMENTO_TIPO_ACTOR','Actor');
	define('ERROR_DOCUMENTO_TIPO','**Debe seleccionar un tipo de documento');
	define('ERROR_DOCUMENTO_TEMA','**Debe seleccionar un tema de documento');
	define('ERROR_DOCUMENTO_SUBTEMA','**Debe seleccionar un subtema de documento');
	define('ERROR_DOCUMENTO_FECHA','**Debe ingresar la fecha de creación');
	define('ERROR_DOCUMENTO_DESCRIPCION','**Debe ingresar la descripción del documento');
	define('ERROR_DOCUMENTO_ARCHIVO','**Debe seleccionar un archivo');
	define('ERROR_DOCUMENTO_VERSION','**Debe indicar la version');
	define('ERROR_DOCUMENTO_ESTADO','**Debe indicar el estado del documento');

	define('DOCUMENTO_TIPO','Tipo');
	define('DOCUMENTO_TEMA','Tema');
	define('DOCUMENTO_SUBTEMA','Subtema');
	define('DOCUMENTO_FECHA','Fecha de creación');
	define('DOCUMENTO_DESCRIPCION','Descripción');
	define('DOCUMENTO_ARCHIVO','Archivo');
	define('DOCUMENTO_VERSION','Versión');
	define('DOCUMENTO_ESTADO','Estado');
	define('DOCUMENTO_SIGLA', 'Sigla');
	define('ERROR_CONFIGURACION_RUTA','No se ha podido cargar el archivo, revise el tamaño');

	define('DOCUMENTO_RESPONSABLE','Responsable');
	define('DOCUMENTO_CONTROLA_ALARMAS','Controla si tiene comunicados sin responder?');
	define('DOCUMENTO_GENERADO','Generada(o)');
	define('DOCUMENTO_REVISIONI','En revisión por RDC');
	define('DOCUMENTO_REVISIONG','En revisión por MT');
	define('DOCUMENTO_REVISIONC','En revisión por CSR');
	define('DOCUMENTO_APROBADO','Aprobada(o)');
	define('DOCUMENTO_EN_FIRMASI','En firmas RDC');
	define('DOCUMENTO_EN_FIRMASG','En firmas MT');
	define('DOCUMENTO_EN_FIRMASC','En firmas CSR');
	define('DOCUMENTO_FIRMADO','Firmado(a)');
	define('DOCUMENTO_NOAPLICA','No Aplica');

	define('EQUIPO_DESTINATARIO','Equipo de Trabajo');

	define('DOCUMENTO_AGREGADO','El documento ha sido agregado con exito');
	define('ERROR_ADD_DOCUMENTO','No se ha podido agregar el documento, error en base de datos');
	define('DOCUMENTO_EDITADO','El documento ha sido actualizado con exito');
	define('ERROR_EDIT_DOCUMENTO','No se ha podido actualizar el documento');
	define('DOCUMENTO_BORRADO','El documento ha sido eliminado con exito');
	define('ERROR_DEL_DOCUMENTO','No se ha podido eliminar el documento<br>Verifique que no tenga compromisos');
	define('DOCUMENTO_MSG_BORRADO','Esta seguro que desea eliminar el documento?');
	define('ERROR_COPIAR_ARCHIVO','No se ha podido cargar el documento');
	define('TABLA_ARTICULO','Articulos');
	define('LISTAR_ARTICULO','Detalle de la normatividad (artículos)');
	define('AGREGAR_ARTICULO','Agregar articulos a una norma');
	define('EDITAR_ARTICULO','Editar articulo');
	define('DOCUMENTO_ESTADOS','Estado');
	define('DOCUMENTO_ESTADO_RESPUESTA','Estado respuesta');

	define('ARTICULO_SUBTEMA','Tipo de Normatividad');
	define('ARTICULO_ALCANCE','Registro');
	define('ARTICULO_NORMA','Norma');
	define('ARTICULO_NOMBRE','Articulo');
	define('ARTICULO_DESCRIPCION','Descripcion del articulo');

	define('ERROR_ARTICULO_SUBTEMA','**Debe indicar el tipo de normatividad');
	define('ERROR_ARTICULO_ALCANCE','**Debe seleccionar el registro');
	define('ERROR_ARTICULO_NORMA','**Debe seleccionar la Norma');
	define('ERROR_ARTICULO_NOMBRE','**Debe ingresar el articulo');
	define('ERROR_ARTICULO_DESCRIPCION','**Debe ingresar la desripcion del articulo');

	define('ARTICULO_AGREGADO','El articulo ha sido agregado con exito');
	define('ERROR_ADD_ARTICULO','No se ha podido agregar el articulo, error en base de datos');
	define('ARTICULO_EDITADO','El articulo ha sido actualizado con exito');
	define('ERROR_EDIT_ARTICULO','No se ha podido actualizar el articulo');
	define('ARTICULO_BORRADO','El articulo ha sido eliminado con exito');
	define('ERROR_DEL_ARTICULO','No se ha podido eliminar el articulo<br>Verifique que no tenga validaciones');
	define('ARTICULO_MSG_BORRADO','Esta seguro que desea eliminar el articulo?');
	define('ERROR_FORMATO_ARCHIVO','Formato de archivo no valido');

?>
