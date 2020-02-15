<?php
/**
 * <ul>
 * <li> MadeOpen <madeopensoftware.com></li>
 * <li> Proyecto PNCAV</li>
 * </ul>
 */
/**
 * Archivo de central de la aplicacion.
 * Implementa el manejo del patron front controler
 *
 * @author Alejandro Daza
 * @version 2019.02
 * @copyright apdaza
 */
//session_register('usuario_sesion_pry');
//session_register('clave_sesion_pry');
session_start();
$session = array('usuario_sesion_pry', 'clave_sesion_pry');
error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);
//error_reporting(E_ALL);
/**
 * Establece una bandera pala validar el acceso correcto
 */
define('_VALID_PRY', 1);

// Incluimos el archivo de configuracion
include('config/conf_clases.php');
include('config/conf.php');
include('config/sec_conf.php');
include('config/constantes.php');

// Verificamos las variables de sesion
if (isset($_REQUEST["txt_login_session"]) and isset($_REQUEST["txt_password_session"])) {
    if ($_REQUEST["txt_login_session"] != '' and $_REQUEST["txt_password_session"] != '') {
        $_SESSION["usuario_sesion_pry"] = $_REQUEST["txt_login_session"];
        $_SESSION["clave_sesion_pry"] = $_REQUEST["txt_password_session"];
    }
}

/* Verificamos que se haya escogido un modulo, sino
 * tomamos el valor por defecto de la configuracion.
 */
if (!empty($_GET['mod']))
    $modulo = $_GET['mod'];
else
    $modulo = MODULO_DEFECTO;

/* Tambien debemos verificar que el valor que nos
 * pasaron, corresponde a un modulo que existe, caso
 * contrario, cargamos el modulo por defecto
 */
if (empty($conf[$modulo]))
    $modulo = MODULO_DEFECTO;

/* Ahora determinamos que archivo de Layout tendra
 * este modulo, si no tiene ninguno asignado, utilizamos
 * el que viene por defecto
 */
if (empty($conf[$modulo]['layout']))
    $conf[$modulo]['layout'] = LAYOUT_DEFECTO;

//verificamos si se inicio desde la aplicacion java
if (isset($_REQUEST["filtro"])) {
    $path_layout = 'default_layout';
    $conf[$modulo]['layout'] = 'default_layout';
    $conf[$modulo]['archivo'] = 'home';
    $path_modulo = 'home';
    $modulo = 'home';
    $_POST['mod'] = 'home';
}

/* Aqui podemos colocar todos los comandos necesarios para
 * realizar las tareas que se deben repetir en cada recarga
 * del index.php - En el ejemplo, conexion a la base de datos.
 */

$db = new CData(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$db->conectar();
$du = new CUserData($db);
$id_usuario = $du->getUserId($_SESSION["usuario_sesion_pry"], $_SESSION["clave_sesion_pry"]);
//var_dump($id_usuario);
$opciones = $du->opciones($id_usuario);
$operador = $_REQUEST['operador'];

$pre_carga = '';
date_default_timezone_set('UTC');
$fecha_cambio = $du->getFechaCambio($id_usuario);
$hoy = date("Y-m-d");
$val =  strtotime ( '+2 month' , strtotime ( $fecha_cambio ) ) ;
$val = date('Y-m-d',$val );

if ($id_usuario != -1) {

    $nombre_usuario = $du->getUserNameById($id_usuario);

    //-------------seguridad-----------------------------//
    $user_security=$du->validarSecurity($id_usuario);

    $service = base64_encode($id_usuario);

    //Verificacion de existencia de cambios de contraseña
    if($user_security==-1 and (isset($_REQUEST["txt_login_session"])) and ( isset($_REQUEST["txt_password_session"])) ){
    	header("Location:?mod=cambio_clave&task=list&service=$service");
      //header("Location:?mod=usuarios&task=editClave&service=$service");

     }else{
    	if(empty($modulo)) $modulo = 'home';
    	$subopciones = $du->subopciones($id_usuario,$modulo,$operador);
    }
    //Verificacion de cambios en los ultimos dos meses
    if ($hoy > $val and (isset($_REQUEST["txt_login_session"])) and ( isset($_REQUEST["txt_password_session"]))){
    	 header("Location:?mod=cambio_clave&task=list&service=$service");
    }else
    {
    	if(empty($modulo)) $modulo = 'home';
    	$subopciones = $du->subopciones($id_usuario,$modulo,$operador);
    }
    //---------------------------------------------------//
    $fecha_ultimo_ingreso = $du->getUserUltimoIngresoById($id_usuario);
    /*if (empty($modulo))
        $modulo = 'home';
    $subopciones = $du->subopciones($id_usuario, $modulo, OPERADOR_DEFECTO);*/
}else {
    $modulo = 'cerrar';
}


/* Tomamos el valor del nivel de acceso */
if (isset($_GET['task'])) {
    $nivel = $du->getUserNivel($id_usuario, $modulo . "&task=" . $_GET['task']);
} else {
    $nivel = $du->getUserNivel($id_usuario, $modulo);
}

if ($nivel == -1) {
    $nivel = $_GET['niv'];
}
$niv = $nivel;


/* Finalmente, cargamos el archivo de Layout que a su vez, se
 * encargara de incluir al modulo propiamente dicho. si el archivo
 * no existiera, cargamos directamente el modulo. Tambien es un
 * buen lugar para incluir Headers y Footers comunes.
 */
$path_layout = LAYOUT_PATH . '/' . $conf[$modulo]['layout'];
$path_modulo = MODULO_PATH . '/' . $conf[$modulo]['archivo'];

if ($pre_carga == '') {
    if (file_exists($path_layout))
        include( $path_layout );
    else
    if (file_exists($path_modulo))
        include( $path_modulo );
    else
        die('Error al cargar el módulo <b>' . $modulo . '</b>. No existe el archivo <b>' . $conf[$modulo]['archivo'] . '</b>');
}else {
    $task = edit;
    $path_layout = LAYOUT_PATH . '/' . $conf[$modulo]['layout'];
    $path_modulo = MODULO_PATH . '/' . $conf[$modulo]['archivo'];
    if (file_exists($path_layout))
        include( $path_layout );
    else
    if (file_exists($path_modulo))
        include( $path_modulo );
    else
        die('Error al cargar el modulo <b>' . $modulo . '</b>. No existe el archivo <b>' . $conf[$modulo]['archivo'] . '</b>');
}
?>
