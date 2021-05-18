<?php
/**
*Gestion Interventoria - Fenix
*
*<ul>
*<li> Redcom Ltda <www.redcom.com.co></li>
*<li> Proyecto RUNT</li>
*</ul>
*/

/**
* Clase CHtmlFormLogin
*
* genera un formulario en base a los atributos de elementos y etiquetas
* para esto requiere que se asigne a cada elemento una etiqueta ya que la
* construccion se hace uno a uno en una tabla html
*
*
* @package  clases
* @subpackage interfaz
* @author Redcom Ltda
* @version 2013.01.00
* @copyright Ministerio de Transporte
*/

class CHtmlFormLogin{
	var $title = null;
	var $etiquetas = null;
	var $elementos = null;
	var $errors = null;
	var $botones = null;
	
	var $id = null;
	var $method = null;
	var $class_etiquetas = null;
	var $class_form = null;
	
	var $enctype = null;
	
	var $spaces = null;
	
	function setTitle($t){
		$this->title = $t;
	}
	
	function setId($id){
		$this->id = $id;
	}
	
	function setSpaces($s){
		$this->spaces = $s;
	}
	
	function setMethod($m){
		$this->method = $m;
	}
	
	function setClassEtiquetas($c){
		$this->class_etiquetas = $c;
	}

/**
* adciona etiquetas al formulario html
* @param $e texto de la etiqueta 
*/
    function addEtiqueta($e){
        $this->etiquetas[count($this->etiquetas)] = $e;
    }	

/**
* adciona cuadros de texto y password al formulario html
* @param $type tipo del elemento
* @param $id identificador del elemento
* @param $name nombre del elemento
* @param $size tamaño del elemento, aplica para elementos de texto
* @param $maxlenght maximo contenido del elemento, aplica para elementos de texto
* @param $class clase del elemento segun hoja de estilos
* @param $events eventos de tipo javascrip que se manejan para el elemento
*/
    function addInputText($type,$id,$name,$size,$maxlength,$value,$class,$events){
        $this->elementos[count($this->elementos)] = array('type'=>$type,'id'=>$id,'name'=>$name,
														  'size'=>$size,'maxlength'=>$maxlength,'value'=>$value,
														  'class'=>$class,'events'=>$events);
    }
/**
* adciona botones al formulario html
* @param $type tipo del elemento (button,submit,reset)
* @param $id identificador del elemento
* @param $name nombre del elemento
* @param $value texto del elemento
* @param $class clase del elemento segun hoja de estilos
* @param $events eventos de tipo javascrip que se manejan para el elemento
*/
    function addInputButton($type,$id,$name,$value,$class,$events){
        $this->botones[count($this->botones)] = array('type'=>$type,'id'=>$id,'name'=>$name,
														  'value'=>$value,'class'=>$class,'events'=>$events);
    }
/**
* adciona espacios de error al formulario html
* @param $id identificador del div de error
* @param $msg texto que contiene el div de error
*/
    function addError($id,$msg){
        $this->errors[count($this->errors)] = array('id'=>$id,'msg'=>$msg);
    }	
	function writeForm(){
		$html = new Chtml('');
		if(!isset($this->title)) $this->title = '';
		if(!isset($this->spaces)) $this->spaces = 0;
		if(count($this->etiquetas)>=1){ 
			$this->class_form = 'formtable';
			$cellspacing = 1;
		}else{
		  	$this->class_form = 'formhidden';
			$cellspacing = 0;
		}
		?>
			<form id="<?php echo $this->id;?>" method="<?php echo $this->method;?>" enctype="<?php echo $this->enctype;?>">
				
				<table width="80%" align="center" border="0" cellpadding="0" cellspacing="<?php echo $cellspacing;?>" class="<?php echo $this->class_form;?>">
					<?php if($this->title != ''){?>
							<tr><td colspan="3" class="titleform"><?php echo $html->traducirTildes($this->title);?></td></tr>
					<?php }?>
					<?php $cont_e = 0;?>
					<?php foreach($this->elementos as $e){?>
					<?php if($e['type']!='hidden'){?>
						<?php if($this->spaces!=0){?>
							<tr><td colspan="3">&nbsp;</td></tr>
						<?php }?>
						<?php if($e['type']=='title'){?>
							<tr><td colspan="3" class="titleinform"><?php echo $html->traducirTildes($e['text']);?></td></tr>
						<?php }else{?>
							<tr>
								<td width="20%" class="<?php echo $this->class_etiquetas;?>" nowrap valign='top'>
									<?php echo $html->traducirTildes($this->etiquetas[$cont_e]);?> 
								</td>
								<td width="40%">
									<?php if($e['type']=='text'){?>
										<input type="<?php echo $e['type'];?>" 
											   id="<?php echo $e['id'];?>" 
											   name="<?php echo $e['name'];?>" 
											   size="<?php echo $e['size'];?>"
											   value="<?php echo $html->traducirTildes($e['value']);?>" 
											   maxlength="<?php echo $e['maxlength'];?>" 
											   class="<?php echo $e['class'];?>"
											   <?php echo $e['events'];?> 
										/>
									<?php }?>
									<?php if($e['type']=='password'){?>
										<input type="<?php echo $e['type'];?>" 
											   id="<?php echo $e['id'];?>" 
											   name="<?php echo $e['name'];?>" 
											   size="<?php echo $e['size'];?>"
											   value="<?php echo $html->traducirTildes($e['value']);?>" 
											   maxlength="<?php echo $e['maxlength'];?>" 
											   class="<?php echo $e['class'];?>"
											   placeholder="<?php echo 'Obrq831+';?>"
											   <?php echo $e['events'];?> 
										/>
									<?php }?>
							
								</td>
								<td width="40%">
									<div id="<?php echo $this->errors[$cont_e]['id'];?>" 
										 class="error" 
										 style="visibility:hidden; display:none;">
										 <?php echo $html->traducirTildes($this->errors[$cont_e]['msg'])?>
									</div>
								</td>
							</tr>
							<?php $cont_e++;?>
						<?php }?>
						
					<?php }else{?>
						<input type="<?php echo $e['type'];?>" 
										   id="<?php echo $e['id'];?>" 
										   name="<?php echo $e['name'];?>" 
										   value="<?php echo $e['value'];?>" 
										   <?php echo $e['events'];?> 
									/>
					<?php }?>
					<?php }?>
					<?php if(isset($this->botones)){?>
						<tr>
							<td colspan="3" class="td_right">
								<?php foreach($this->botones as $b){?>
									<?php if($b['type']=='button' || $b['type']=='submit' || $b['type']=='reset'){?>
										<input type="<?php echo $b['type'];?>" 
											   id="<?php echo $b['id'];?>" 
											   name="<?php echo $b['name'];?>" 
											   value="<?php echo $html->traducirTildes($b['value']);?>" 
											   class="<?php echo $b['class'];?>"
											   <?php echo $b['events'];?> 
										/>
									<?php }?>
								<?php }?>
							</td>
						</tr>
					<?php }?>
				</table>
			</form>
		<?php
	}
	
	function crearFormulario($id,$method,$enctype){
		?>
			<form id="<?php echo $id;?>" method="<?php echo $method;?>" enctype="<?php echo $enctype;?>">
		<?php
	}
	
	function cerrarFormulario(){
		?>
			</form>
		<?php
	}
	
	function crearCheck($id,$valor,$texto,$checked,$events){
		$html = new Chtml('');
		?>
		<input type="checkbox" 
			   id="<?php echo $id;?>" 
			   name="<?php echo $id;?>" 
			   value="<?php echo $valor;?>" 
			   <?php echo $events;?>
			   <?php echo $checked;?>> <?php echo $html->traducirTildes($texto);?>
		<?php
	}
	
	function crearRadio($id,$valor,$texto,$checked,$events){
		$html = new Chtml('');
		?>
		<input type="radio" 
			   id="<?php echo $id;?>" 
			   name="<?php echo $id;?>" 
			   value="<?php echo $valor;?>" 
			   <?php echo $events;?>
			   <?php echo $checked;?>> <?php echo $html->traducirTildes($texto);?>
		<?php
	}
	function crearTextArea($id,$valor,$cols,$rows,$events){
		$html = new Chtml('');
		?>
		<textarea id="<?php echo $id;?>" 
			   name="<?php echo $id;?>" 
			   cols="<?php echo $cols;?>" 
			   rows="<?php echo $rows;?>" 
			   <?php echo $events;?> 
		><?php echo $html->traducirTildes($valor);?></textarea>
		<?php
	}
	
	function crearTextField($type,$id,$size,$value,$maxlength,$class,$events){
		$html = new Chtml('');
		?>
			<input type="<?php echo $type;?>" 
				   id="<?php echo $id;?>" 
				   name="<?php echo $id;?>" 
				   size="<?php echo $size;?>"
				   value="<?php echo $html->traducirTildes($value);?>" 
				   maxlength="<?php echo $maxlength;?>" 
				   class="<?php echo $class;?>"
				   <?php echo $events;?> 
			/>
		<?php
	}
	
	function crearBoton($tipo,$id,$valor,$events,$class="button"){
		$html = new Chtml('');
		?>
		<input type="<?php echo $tipo;?>" 
			   id="<?php echo $id;?>" 
			   name="<?php echo $id;?>" 
			   value="<?php echo $html->traducirTildes($valor);?>" 
			   class="<?php echo $class;?>"
			   <?php echo $events;?> 
		/>
		<?php
	}
    
  function crearDivError($id,$msg){
      $html = new Chtml('');
      ?>
      <div id="<?php echo $id;?>" 
          class="error" 
          style="visibility:hidden; display:none;">
          <?php echo $html->traducirTildes($msg);?>
      </div>
      <?php
  }
  
  function crearSelect($id,$name,$class,$events,$texto,$options,$value){
    $html = new Chtml('');
    ?>
    <select id="<?php echo $id;?>" 
        name="<?php echo $name;?>" 
        class="<?php echo $class;?>"
        <?php echo $events;?> 
        >
          <option value="-1"><?php echo $html->traducirTildes(SELECCIONE_UN." ".$texto);?></option>
          <?php foreach($options as $s){?>
            <option value="<?php echo $s['value'];?>"
              <?php if($value==$s['value']) echo "selected"?>>
              <?php echo $html->traducirTildes($s['texto']);?>
            </option>
          <?php }?>
        </select>
    <?php
  }

}

?>
