<?php
/**
 * PNCAV
 *
 * <ul>
 * <li> MadeOpen <madeopensoftware.com></li>
 * <li> Proyecto PNCAV</li>
 * </ul>
 */

require_once('CHtmlDataTable.php');

/**
 * Clase CHtmlDataTableAlignable
 *
 * genera una tabla en base a un arreglo de datos y otro con los titulos de la tabla
 *
 * @package  clases
 * @subpackage interfaz
 * @author Alejandro Daza
 * @version 2014.01.00
 * @see CHtmlDataTable
 */
class CHtmlDataTableAlignable extends CHtmlDataTable {

    var $alignColumns = null;
    var $wrapColumns = null;
    /**
     * Escribe la tabla en base a los parámetros establecidos.
     * 
     * @param type $nivel
     */
    function writeDataTable($nivel) {
        $html = new CHtml('');
        if (!isset($this->pag))
            $this->pag = 0;
        switch ($this->type) {
            case 1:
                ?>
                <div class="row-fluid">
                    <div class="span12">
                        <table class="table table-bordered table-hover table-condensed">
                            <thead>
                                <tr>				
                                    <th colspan="<?php echo count($this->titleRow) + 2 ?>" class="titledatatable">
                                        <?php if (($this->pag == 1)) { ?>
                                            <input type="image" 
                                                   src="./templates/img/ico/atras.gif" 
                                                   width="20" 
                                                   align="absmiddle" 
                                                   alt="<?php echo BTN_ATRAS; ?>" 
                                                   onclick="changePage('back');"/>
                                               <?php } ?>
                                               <?php echo $html->traducirTildes($this->titleTable) . " (" . $html->traducirTildes(PAGINA_PAGINACION) ?>
                                        <span id="pagina">1</span>
                                        <?php echo $html->traducirTildes(" " . CONCATENADOR_DE . " ") ?>
                                        <span id="paginas"><?php echo $this->countPag(); ?></span>)
                                        <?php if (($this->pag == 1)) { ?>
                                            <input type="image" 
                                                   src="./templates/img/ico/adelante.gif" 
                                                   width="20" 
                                                   align="absmiddle" 
                                                   alt="<?php echo BTN_ADELANTE; ?>" 
                                                   onclick="changePage('foward');"/>
                                               <?php } ?>								
                                    </th>
                                </tr>
                                <tr>
                                    <?php if (($this->pag == 1)) { ?><th style="font-size: 12px">#</th><?php } ?>
                                    <?php $cont_titulos = 1; ?>
                                    <?php
                                    $array_url = preg_split("'&'", $_SERVER['REQUEST_URI']);
                                    $cad_url = "";
                                    if (substr($array_url[count($array_url) - 1], 0, 5) == "orden") {
                                        for ($pau = 0; $pau < (count($array_url) - 1); $pau++) {
                                            $cad_url .= $array_url[$pau] . "&";
                                        }
                                        $cad_url = substr($cad_url, 0, strlen($cad_url) - 1);
                                    } else {
                                        $cad_url = $_SERVER['REQUEST_URI'];
                                    }
                                    $this->orderData($_REQUEST['orden'], $_REQUEST['ordcri']);
                                    ?>
                                    <?php foreach ($this->titleRow as $t) { ?>
                                        <th>
                                            <?php if (($this->pag == 1)) { ?>
                                                <?php if ($_REQUEST['ordcri'] == 'asc') { ?>
                                                    <a href="<?php echo $cad_url; ?>&orden=<?php echo $cont_titulos; ?>&ordcri=des&<?php echo $this->pag_req ?>">
                                                    <?php } else { ?>
                                                        <a href="<?php echo $cad_url; ?>&orden=<?php echo $cont_titulos; ?>&ordcri=asc&<?php echo $this->pag_req ?>">
                                                        <?php } ?>  
                                                        <?php
                                                        if ($_REQUEST['orden'] == $cont_titulos) {
                                                            if ($_REQUEST['ordcri'] == 'asc') {
                                                                echo "<img src='./templates/img/ico/arriba.gif' border='0'></img>";
                                                            } else {
                                                                echo "<img src='./templates/img/ico/abajo.gif' border='0'></img>";
                                                            }
                                                        }
                                                        ?>
                                                        <div style="font-size: 12px;"><?php echo $html->traducirTildes($t); ?></div>
                                                    </a>
                                                <?php } else { ?>
                                                    <div style="font-size: 12px;"><?php echo $html->traducirTildes($t); ?></div>
                                                <?php } ?>
                                        </th>
                                        <?php $cont_titulos++; ?>
                                    <?php } ?>
                                    <?php if (isset($this->addLink) || isset($this->editLink) || isset($this->seeLink) || isset($this->deleteLink) || isset($this->otrosLink)) { ?>
                                        <th style='font-size: 12px; color: white'><?php echo $html->traducirTildes(OPCIONES); ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $cont_rows = 1; ?>
                                <?php if (isset($this->dataRows)) { ?>
                                    <?php foreach ($this->dataRows as $r) { ?>								
                                        <?php $cont_rows++; ?>
                                        <?php
                                        if ($cont_rows % 2 == 0)
                                            $estilo = 'celldatatablenopar';
                                        else
                                            $estilo = 'celldatatablepar';
                                        ?>
                                        <?php if ($this->pag == 1) { ?>
                                            <?php if ($cont_rows > PAG_CANT + 1) { ?>
                                                <tr id="div_<?php echo $cont_rows; ?>" style="visibility:hidden; display:none;">
                                                <?php } else { ?>
                                                <tr id="div_<?php echo $cont_rows; ?>" style="visibility:visible; display:'';">
                                                <?php } ?>
                                            <?php } else { ?>
                                            <tr>
                                            <?php } ?>
                                            <?php $cont = 0; ?>
                                            <?php if (($this->pag == 1)) { ?>
                                                <td style="font-size: 12px">&nbsp;<?php echo $cont_rows - 1; ?>&nbsp;</td>
                                            <?php } ?>
                                            <?php foreach ($r as $c) { ?>
                                                <?php if ($cont != 0) { ?>
                                                    <td class="<?php echo $estilo ?>" <?php echo $this->wrapColumns[$cont] ?>>
                                                        <?php if (isset($this->alignColumns[$cont])) { ?>
                                                            <div style="text-align:<?php echo $this->alignColumns[$cont] ?>;">
                                                            <?php } else { ?>
                                                                <div style="text-align:center; font-size: 12px;">
                                                                <?php } ?>
                                                                    <?php 
                                                                    if (isset($this->formatRow[$cont - 1])) {
                                                                        $c = number_format($c, $this->formatRow[$cont - 1][0], $this->formatRow[$cont - 1][1], $this->formatRow[$cont - 1][2]);
                                                                    }
                                                                    ?>
                                                                &nbsp;<?php echo $html->traducirTildes($c); ?>&nbsp;
                                                            </div>
                                                    </td>
                                                <?php } else { ?>
                                                    <?php $id = $c; ?>
                                                <?php } ?>
                                                <?php $cont++; ?>
                                            <?php } ?>
                                            <td class="<?php echo $estilo ?>" nowrap>
                                                <?php if (!empty($this->seeLink)) { ?>
                                                    <a href="<?php echo $this->seeLink ?>&id_element=<?php echo $id ?>" target="<?php echo $this->targetSee; ?>"><img src="./templates/img/ico/ver.gif" border="0" width="20" alt="<?php echo ALT_VER ?>"/></a>
                                                <?php } ?>
                                                <?php if ($nivel == 1) { ?>
                                                    <?php if (!empty($this->digitalizationLink)) { ?>
                                                        <a href="<?php echo $this->digitalizationLink ?>&id_element=<?php echo $id ?>" target="<?php echo $this->targetDigitalization; ?>"><img src="./templates/img/ico/agregar.gif" border="0" width="20" alt="<?php echo BTN_AGREGAR ?>"/></a>
                                                    <?php } ?>
                                                    <?php if (!empty($this->editLink)) { ?>
                                                        <a href="<?php echo $this->editLink ?>&id_element=<?php echo $id ?>" target="<?php echo $this->targetEdit; ?>"><img src="./templates/img/ico/editar.gif" border="0" width="20" alt="<?php echo ALT_EDITAR ?>"/></a>
                                                    <?php } ?>
                                                    <?php if (!empty($this->deleteLink)) { ?>
                                                        <a href="<?php echo $this->deleteLink ?>&id_element=<?php echo $id ?>"><img src="./templates/img/ico/borrar.gif" border="0" width="20" alt="<?php echo ALT_BORRAR ?>"/></a>
                                                    <?php } ?>
                                                    <?php if (isset($this->otrosLink)) { ?>
                                                        <?php foreach ($this->otrosLink as $o) { ?>
                                                            <a href="<?php echo $o['link']; ?>&id_element=<?php echo $id ?>"><img src="./templates/img/ico/<?php echo $o['img']; ?>" border="0" width="20" alt="<?php echo $o['alt'] ?>"/></a>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </td>	
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                <?php if (is_array($this->sumColumns)) { ?>
                                    <tr>
                                        <?php
                                        $sumas = $this->sumData();
                                        if (isset($sumas)) {
                                            foreach ($sumas as $s) {

                                                if ($s != '0') {
                                                    echo "<td class='sumdatatable'>" . $s . "</td>";
                                                } else {
                                                    echo "<td>&nbsp;</td>";
                                                }
                                            }
                                        }
                                        ?>
                                    </tr>
                                    <?php if (isset($this->versusSum)) { ?>
                                        <tr>
                                            <?php
                                            $sumas = $this->sumInfo();
                                            if (isset($sumas)) {
                                                foreach ($sumas as $s) {
                                                    if ($s != '0') {
                                                        echo "<td class='sumdatatable'>" . $s . "</td>";
                                                    } else {
                                                        echo "<td>&nbsp;</td>";
                                                    }
                                                }
                                            }
                                            ?>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                <?php if ((!empty($this->addLink) && $nivel == 1)) { ?>
                                    <tr>
                                        <td colspan="<?php echo count($this->titleRow) + 2 ?>" class="celladddatatable">
                                            <?php if ((!empty($this->addLink) && $nivel == 1)) { ?>
                                                <a href="<?php echo $this->addLink ?>"><img src="./templates/img/ico/agregar.gif" border="0" width="20" align="absmiddle" />&nbsp;&nbsp;<?php echo $html->traducirTildes($this->textAddLink); ?></a>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if (($this->pag == 1)) { ?>
                    <form id="frm_visivilidad">
                        <input type="hidden" id="rows" value="<?php echo $cont_rows; ?>" />
                        <input type="hidden" id="init" value="2" />
                        <input type="hidden" id="size" value="<?php echo PAG_CANT; ?>" />
                    </form>
                <?php } ?>
                <?php
                break;
            case 2:
                ?>
                <div class="row-fluid">
                    <div class="span12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="2"><?php echo $html->traducirTildes($this->titleTable) ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $cont_rows = 0; ?>
                                <?php foreach ($this->dataRows as $r) { ?>
                                    <tr>
                                        <td><?php echo $html->traducirTildes($this->titleRow[$cont_rows]); ?></td>
                                        <td><?php echo $html->traducirTildes($r); ?></td>
                                    </tr>
                                    <?php $cont_rows++; ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
                break;
        }
    }

}
