<?php

require '../config/connection.php';

Class monitoreoM {

    public function _construct() { /* Constructor */
    }

    function selectAll($agencias, $txtRegion, $txtAgencia, $txtFechaInicio, $txtFechaFin, $txtArea, $txtSeccion) { //mostrar todos los registros
        $valor_array = explode(',', $agencias); //explode convierte string a array e implode convierte array a string
        $longitud = count($valor_array);
        for ($i = 0; $i < $longitud; $i++) {
            $vAgencia = trim($valor_array[$i]);
            if ($vAgencia == '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM monitoreo.calificaciones "
                        . "WHERE AGENCIA LIKE '%$vAgencia%' );");
            } else if ($vAgencia != '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM monitoreo.calificaciones "
                        . "WHERE AGENCIA = '$vAgencia' );");
            } else if ($vAgencia == '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM monitoreo.calificaciones "
                        . "WHERE AGENCIA LIKE '%$vAgencia%' );");
            } else if ($vAgencia != '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM monitoreo.calificaciones "
                        . "WHERE AGENCIA = '$vAgencia' );");
            }
        }

        if (($txtFechaInicio == '' || $txtFechaFin == '') && $txtAgencia == '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%'  
                            AND AGENCIA LIKE '$txtAgencia%' 
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%' 
                            );");
        } else if (($txtFechaInicio == '' || $txtFechaFin == '') && $txtAgencia != '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%'  
                            AND AGENCIA = '$txtAgencia'
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%');");
        } else if (($txtFechaInicio != '' && $txtFechaFin != '') && $txtAgencia != '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND AGENCIA = '$txtAgencia'
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%' 
                            AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin');");
        } else if (($txtFechaInicio != '' && $txtFechaFin != '') && $txtAgencia == '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND AGENCIA LIKE '$txtAgencia%'
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%' 
                            AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin');");
        }
        $sql = "SELECT Id,
                IDENTIFICACION,
                DATE_FORMAT(STR_TO_DATE(FechaAtencion,'%d/%m/%Y'),'%d/%m/%Y') as FECHA,
                REGION,
                AGENCIA,
                SECCION,
                CASE 
                    WHEN TRANSACCION LIKE '%Cr?dito%' THEN replace(TRANSACCION,'?','é')
                    WHEN TRANSACCION LIKE '%ci?n%' THEN replace(TRANSACCION,'?','ó')
                    WHEN TRANSACCION LIKE '%si?n%' THEN replace(TRANSACCION,'?','ó')
                    WHEN TRANSACCION LIKE '%D?bito%' THEN replace(TRANSACCION,'?','é')
                ELSE TRANSACCION END AS TRANSACCION,
                UPPER(AGENT) AS USUARIO_KMB,
                UPPER(EVALUADOR) AS EVALUADOR,
                EstadoMonitoreo,
                Criterio,
                TMA
            FROM bgr.TMP1;";
        return ejecutarConsulta($sql);
        ejecutarConsulta("DROP TABLE BGR.TMP, BGR.TMP1");
    }

    function selectById($Id) { //mostrar un registro
        $sql = "SELECT * FROM monitoreo.calificaciones where id = '$Id'";
        return ejecutarConsultaSimple($sql);
    }
}

?>