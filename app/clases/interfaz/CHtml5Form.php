<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CHtml5Form {

    var $elementos;
    var $title;

    function setTitle($title) {
        $this->title = $title;
    }

    function addInput($type, $id, $name, $etiqueta, $placeholder, $size, 
                      $maxlength, $value, $pattern, $title, $autofocus, $required) {
        $this->elementos[count($this->elementos)] = array('type' => $type, 'id' => $id,
            'name' => $name, 'etiqueta' => $etiqueta, 'placeholder' => $placeholder,
            'size' => $size, 'maxlength' => $maxlength, 'value' => $value, 'pattern' => $pattern,
            'title' => $title, 'autofocus' => $autofocus, 'required' => $required);
    }

    function writeForm() {
        ?>
        <form class="form-horizontal" role="form" method="post">
            <?php foreach ($this->elementos as $elemento) { ?>
                <div class="form-group">
                    <label for="<?php echo $elemento['name']?>" class="col-lg-2 control-label"><?php echo $elemento['etiqueta'] ?></label>
                    <div class="col-lg-10">
                        <input class="form-control" 
                               type="<?php echo $elemento['type'] ?>"
                               id="<?php echo $elemento['id'] ?>"
                               name="<?php echo $elemento['name'] ?>"
                               <?php if ($elemento['placeholder'] != null) { ?> 
                                   placeholder="<?php echo $elemento['placeholder'] ?>"
                               <?php } ?>
                               <?php if ($elemento['size'] != null) { ?> 
                                   size="<?php echo $elemento['size'] ?>"
                               <?php } ?>
                               <?php if ($elemento['maxlength'] != null) { ?> 
                                   maxlength="<?php echo $elemento['maxlength'] ?>"
                               <?php } ?>
                               <?php if ($elemento['value'] != null) { ?> 
                                   value="<?php echo $elemento['value'] ?>" 
                               <?php } ?>
                               <?php if ($elemento['pattern'] != null) { ?> 
                                   pattern="<?php echo $elemento['pattern'] ?>"
                                   title="<?php echo $elemento['title']?>"
                               <?php } ?>
                               <?php if ($elemento['autofocus'] == 1) { ?> 
                                   autofocus
                               <?php } ?>
                               <?php if ($elemento['required'] == 1) { ?> 
                                   required
                               <?php } ?>
                               />
                    </div>
                </div>
            <?php } ?>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <button type="submit" class="btn btn-default">Enviar</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <button type="reset" class="btn btn-default">Limpiar</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <button type="" class="btn btn-default">Cancelar</button>
                </div>
            </div>
        </form>
        <?php
    }

}
