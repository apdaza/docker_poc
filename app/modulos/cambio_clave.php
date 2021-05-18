<?php

defined('_VALID_PRY') or die('Restricted access');
$task = $_REQUEST['task'];
$du = new CUserData($db);

if (empty($task))
    $task = 'list';

switch ($task) {
    case 'list':
        //$form = new CHtmlFormLogin();

        $id= base64_decode($_REQUEST['service']);
		    $form = new CHtmlForm();
        $form->setId('frm_cambio_clave');
        $form->setTitle(CAMBIAR_CLAVE);
        $form->setMethod('post');
        //$form->setSpaces(1);
        //$form->setClassEtiquetas('td_label');
        $form->addEtiqueta("Clave Anterior");
        $form->addInputText('password', 'txt_clave_anterior', 'txt_clave_anterior', '15', '15', $clave_anterior, '', 'onkeypress="ocultarDiv(\'error_clave_anterior\');"');
        $form->addError('error_clave_anterior', ERROR_PASSWORD);

		    $form->addEtiqueta("Nueva Clave");
        $form->addInputText('password', 'txt_nueva_clave_1', 'txt_nueva_clave_1', '15', '15', '', '', 'onkeypress="ocultarDiv(\'error_nueva_clave_1\');"');
		    $form->addError('error_nueva_clave_1', ERROR_USUARIO_NUEVO_PASSWORD);

		    $form->addEtiqueta("Repetir nueva Clave");
        $form->addInputText('password', 'txt_nueva_clave_2', 'txt_nueva_clave_2', '15', '15', '', '', 'onkeypress="ocultarDiv(\'error_nueva_clave_2\');"');
        $form->addError('error_nueva_clave_2', ERROR_USUARIO_NUEVO_PASSWORD);

		/*echo "<script type='text/javascript'>
            $(document).ready(function(){

            });
        </script>";*/

        $form->addInputText('hidden','txt_id','txt_id','15','15',$id,'','');
		    $form->addInputText('hidden','txt_clave_nue','txt_clave_nue','30','30',$_SESSION["clave_sesion_pry"],'','');

        $form->addInputButton('button', 'ok', 'ok', BTN_INGRESAR, 'button', 'onclick="validar_nueva_clave();"');

		$form->writeForm();

		$form = new CHtmlFormLogin();
		$form->addEtiqueta('<center><p style= color:white ; font-size:8px;><br>La nueva contraseña debe tener un caracter en mayúscula, un caracter en minúscula, <br>y un número</p></>');
    //$form->addDivision('division','<>');
		$form->addError('','');
		$form->writeForm();

        break;


    case 'cambiar_clave':
    //die("a cambiar");
        $c_a = $_REQUEST['txt_clave_anterior'];
        $c_n1 = $_REQUEST['txt_nueva_clave_1'];
        $c_n2 = $_REQUEST['txt_nueva_clave_2'];
        $id = $_REQUEST['txt_id'];

      $z=$du->cambiarClave($id, $c_a,$c_n1);
      if($z){
         $m = "La clave fue cambiada exitosamente";

      }else{
           $m = "La clave no pudo ser cambiada";
      }
        echo $html->generaLink( "?mod=home",'aprobar.gif',$m);

    break;

    default:
        /**
         * en caso de que la variable task no este definida carga la p�gina en construcci�n
         */
        include('templates/html/under.html');
        break;
}
?>
