<?php

/**
 *
 *
 * <ul>
 * <li> MadeOpen <madeopensoftware.com></li>
 * <li> Proyecto PNCAV</li>
 * </ul>
 */

/**
 * Clase OperadorData
 * Usada para la definicion de todas las funciones propias del objeto OPERADOR

 * @package  clases
 * @subpackage datos
 * @author Alejandro Daza
 * @version 2019.02
 * @copyright SERTIC - MINTICS
 */
class COperadorData {

    var $db;

    function COperadorData($db) {
        $this->db = $db;
    }

    function loadOperadores($criterio, $orden) {
        $operadores = null;
        $sql = "SELECT *
                FROM operador
                WHERE " . $criterio . ' ORDER BY ' . $orden;
        $r = $this->db->ejecutarConsulta($sql);

        $cont = 0;
        while ($w = mysqli_fetch_array($r)) {
            $operadores[$cont]['id'] = $w['ope_id'];
            $operadores[$cont]['nombre'] = $w['ope_nombre'];
            $operadores[$cont]['siglas'] = $w['ope_sigla'];
            $cont++;
        }

        return $operadores;
    }

    function getOperadorById($id) {
        $operadorData = null;
        $sql = "SELECT *
                        FROM operador
                        WHERE ope_id = " . $id;
        $r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
        if ($r) {
            $operadorData["id"] = $r["ope_id"];
            $operadorData["nombre"] = $r["ope_nombre"];
            $operadorData["siglas"] = $r["ope_sigla"];
            $operadorData["contrato"] = $r["ope_contratoNo"];
            return $operadorData;
        } else {
            return -1;
        }
    }

}

?>
