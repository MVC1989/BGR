<?php

require '../config/connection.php';

Class reportesM {

    public function _construct() { /* Constructor */
    }

    function selectAll($agencias, $txtRegion, $txtAgencia, $txtTipoCliente, $txtFechaInicio, $txtFechaFin, $txtArea, $txtSeccion) { //mostrar todos los registros
        $valor_array = explode(',', $agencias); //explode convierte string a array e implode convierte array a string
        $longitud = count($valor_array);
        for ($i = 0; $i < $longitud; $i++) {
            $vAgencia = trim($valor_array[$i]);
            if ($vAgencia == '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else if ($vAgencia != '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA = '$vAgencia'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else if ($vAgencia == '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else if ($vAgencia != '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA = '$vAgencia'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            }
        }

        if (($txtFechaInicio == '' || $txtFechaFin == '') && $txtAgencia == '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA LIKE '$txtAgencia%' 
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%' 
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio == '' || $txtFechaFin == '') && $txtAgencia != '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA = '$txtAgencia'
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio != '' && $txtFechaFin != '') && $txtAgencia != '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA = '$txtAgencia'
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%' 
                            AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio != '' && $txtFechaFin != '') && $txtAgencia == '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA LIKE '$txtAgencia%'
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%' 
                            AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        }
        $sql = "SELECT 
                DATE_FORMAT(STR_TO_DATE(fecha_atencion,'%d/%m/%Y'),'%d/%m/%Y') as FECHA,
                replace(UPPER(NOMBRE_CLIENTE),'?','Ñ') AS NOMBRE_CLIENTE,
                IDENTIFICACION,
                AGENCIA,
                SECCION,
                CASE 
                    WHEN TRAMITES LIKE '%Cr?dito%' THEN replace(TRAMITES,'?','é')
                    WHEN TRAMITES LIKE '%ci?n%' THEN replace(TRAMITES,'?','ó')
                    WHEN TRAMITES LIKE '%si?n%' THEN replace(TRAMITES,'?','ó')
                    WHEN TRAMITES LIKE '%D?bito%' THEN replace(TRAMITES,'?','é')
                    WHEN TIPO_TRANSACCION = '' THEN TRAMITES
                ELSE replace(TIPO_TRANSACCION,'?','ó') END AS TIPO_TRANSACCION,
                CASE WHEN CAJERO = '' THEN USUARIO ELSE CAJERO END AS CAJERO,
                UPPER(AGENT) AS USUARIO_KMB,
                RESPUESTA_1,
                RESPUESTA_1_1,
                RESPUESTA_2,
                RESPUESTA_2_1,
                RESPUESTA_3,
                RESPUESTA_3_1,
                RESPUESTA_4,
                RESPUESTA_4_1,
                RESPUESTA_5,
                RESPUESTA_5_1,
                RESPUESTA_6,
                RESPUESTA_6_1,
                RESPUESTA_7,
                RESPUESTA_7_1,
                RESPUESTA_8,
                RESPUESTA_8_1,
                RESPUESTA_9,
                RESPUESTA_9_1,
                CASE 
                    WHEN RESPUESTA_10 = 'MUY FACIL' THEN 1
                    WHEN RESPUESTA_10 = 'FACIL' THEN 2
                    WHEN RESPUESTA_10 = 'POCO FACIL' THEN 3
                    WHEN RESPUESTA_10 = 'ALGO DIFICIL' THEN 3
                    WHEN RESPUESTA_10 = 'DIFICIL' THEN 4
                    WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 5
                END AS RESPUESTA_10,
                RESPUESTA_10_1,
                RESPUESTA_11,
                RESPUESTA_11_1,
                RESPUESTA_12,
                RESPUESTA_12_1,
                RESPUESTA_13,
                RESPUESTA_13_1
            FROM bgr.TMP1
            WHERE ResultLevel1 LIKE 'CU1%';";
        return ejecutarConsulta($sql);
        ejecutarConsulta("DROP TABLE BGR.TMP, BGR.TMP1");
    }
    
    function selectAllCanales($txtCanal, $txtFechaInicio, $txtFechaFin) { //mostrar todos los registros
        $valor_array = explode(',', $txtCanal); //explode convierte string a array e implode convierte array a string
        $longitud = count($valor_array);
        for ($i = 0; $i < $longitud; $i++) {
            $vCanal = trim($valor_array[$i]);
            if ($vCanal == '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINALCANALES "
                        . "WHERE SEGMENTO LIKE '%$vCanal%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else if ($vCanal != '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINALCANALES "
                        . "WHERE SEGMENTO = '$vCanal'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else if ($vCanal == '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINALCANALES "
                        . "WHERE SEGMENTO LIKE '%$vCanal%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else if ($vCanal != '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINALCANALES "
                        . "WHERE SEGMENTO = '$vCanal'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            }
        }

        if (($txtFechaInicio == '' || $txtFechaFin == '') && $txtCanal == '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            SEGMENTO like '%$txtCanal%'  
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio == '' || $txtFechaFin == '') && $txtCanal != '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            SEGMENTO like '%$txtCanal%'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio != '' && $txtFechaFin != '') && $txtCanal != '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            SEGMENTO like '%$txtCanal%'  
                            AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio != '' && $txtFechaFin != '') && $txtCanal == '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            SEGMENTO like '%$txtCanal%' 
                            AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        }
        $sql = "SELECT 
                DATE_FORMAT(STR_TO_DATE(fecha_atencion,'%d/%m/%Y'),'%d/%m/%Y') as FECHA,
                replace(UPPER(NOMBRE_CLIENTE),'?','Ñ') AS NOMBRE_CLIENTE,
                IDENTIFICACION,
                SEGMENTO,
                CASE 
                    WHEN TRAMITES LIKE '%Cr?dito%' THEN replace(TRAMITES,'?','é')
                    WHEN TRAMITES LIKE '%ci?n%' THEN replace(TRAMITES,'?','ó')
                    WHEN TRAMITES LIKE '%si?n%' THEN replace(TRAMITES,'?','ó')
                    WHEN TRAMITES LIKE '%D?bito%' THEN replace(TRAMITES,'?','é')
                    WHEN TIPO_TRANSACCION = '' THEN TRAMITES
                ELSE replace(TIPO_TRANSACCION,'?','ó') END AS TIPO_TRANSACCION,
                CASE WHEN CAJERO = '' THEN USUARIO ELSE CAJERO END AS CAJERO,
                UPPER(AGENT) AS USUARIO_KMB,
                RESPUESTA_1,
                RESPUESTA_1_1,
                RESPUESTA_2,
                RESPUESTA_2_1,
                RESPUESTA_3,
                RESPUESTA_3_1,
                RESPUESTA_4,
                RESPUESTA_4_1,
                RESPUESTA_5,
                RESPUESTA_5_1,
                RESPUESTA_6,
                RESPUESTA_6_1,
                RESPUESTA_7,
                RESPUESTA_7_1,
                RESPUESTA_8,
                RESPUESTA_8_1,
                RESPUESTA_9,
                RESPUESTA_9_1,
                RESPUESTA_10,
                RESPUESTA_10_1,
                RESPUESTA_11,
                RESPUESTA_11_1,
                RESPUESTA_12,
                RESPUESTA_12_1,
                RESPUESTA_13,
                RESPUESTA_13_1,
                CASE 
                    WHEN RESPUESTA_14 = 'MUY FACIL' THEN 1
                    WHEN RESPUESTA_14 = 'FACIL' THEN 2
                    WHEN RESPUESTA_14 = 'POCO FACIL' THEN 3
                    WHEN RESPUESTA_14 = 'ALGO DIFICIL' THEN 3
                    WHEN RESPUESTA_14 = 'DIFICIL' THEN 4
                    WHEN RESPUESTA_14 = 'MUY DIFICIL' THEN 5
                END AS RESPUESTA_14,
                RESPUESTA_14_1,
                RESPUESTA_15,
                RESPUESTA_15_1
            FROM bgr.TMP1
            WHERE ResultLevel1 LIKE 'CU1%';";
        return ejecutarConsulta($sql);
        ejecutarConsulta("DROP TABLE BGR.TMP, BGR.TMP1");
    }
    
    function reportAtributos($agencias, $txtRegion, $txtAgencia, $txtTipoCliente, $txtFechaInicio, $txtFechaFin, $txtArea, $txtSeccion) { //mostrar todos los registros
        $valor_array = explode(',', $agencias); //explode convierte string a array e implode convierte array a string
        $longitud = count($valor_array);
        for ($i = 0; $i < $longitud; $i++) {
            $vAgencia = trim($valor_array[$i]);
            if ($vAgencia == '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else if ($vAgencia != '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA = '$vAgencia'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else if ($vAgencia == '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else if ($vAgencia != '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA = '$vAgencia'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            }
        }

        if (($txtFechaInicio == '' || $txtFechaFin == '') && $txtAgencia == '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA LIKE '$txtAgencia%' 
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%' 
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio == '' || $txtFechaFin == '') && $txtAgencia != '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA = '$txtAgencia'
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio != '' && $txtFechaFin != '') && $txtAgencia != '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA = '$txtAgencia'
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%' 
                            AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio != '' && $txtFechaFin != '') && $txtAgencia == '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA LIKE '$txtAgencia%'
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%' 
                            AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        }
        if($txtSeccion == 'Cajas' || $txtSeccion == 'CAJAS'){
            $sql = "SELECT 
                        UPPER(AGENCIA) AS AGENCIA,
                        ROUND((SUM(RESPUESTA_1)/SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END))/7*100,2) AS ASESORIA,
                        ROUND((SUM(RESPUESTA_2)/SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END))/7*100,2) AS CLARIDAD,
                        ROUND((SUM(RESPUESTA_3)/SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END))/7*100,2) AS AMABILIDAD,
                        ROUND((SUM(RESPUESTA_4)/SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END))/7*100,2) AS EMPATIA,
                        ROUND((SUM(RESPUESTA_5)/SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END))/7*100,2) AS EFECTIVIDAD,
                        ROUND((SUM(RESPUESTA_6)/SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END))/7*100,2) AS PERSONALIZACION,
                        ROUND((SUM(RESPUESTA_7)/SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*100,2) AS AGILIDAD,
                        ROUND((SUM(RESPUESTA_8)/(SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE 1 END) - SUM(CASE WHEN RESPUESTA_8 = 'NO APLICA' THEN 1 ELSE 0 END)))/7*100,2) AS ACCESIBILIDAD,
                        ROUND((
                            IFNULL(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                                    +
                                    SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END))
                                    /
                                    (SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                                    +
                                    SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)))/7*0.17,0)
                                    +
                            IFNULL(((SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END) 
                                    + 
                                    SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END))
                                    /
                                    (SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)
                                    +
                                    SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)))/7*0.25,0)
                                    +
                            IFNULL(((SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                                    +
                                    SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                                    /
                                    (SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                                    +
                                    SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)))/7*0.21,0)
                                    +
                                    (SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)
                                    /
                                    SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*0.17)
                        /CASE WHEN SECCION = 'CAJAS' THEN 0.42 ELSE 0.8 END *100,2)
                        FROM BGR.TMP1 g1 WHERE g1.AGENCIA = g.AGENCIA AND SECCION = 'CAJAS'
                        AND ResultLevel1 LIKE 'CU1%') AS VISION
                FROM bgr.TMP1 G
                WHERE ResultLevel1 LIKE 'CU1%' AND SECCION = 'CAJAS'
                GROUP BY AGENCIA;";
        }
        else{
            $sql = "SELECT 
                        UPPER(AGENCIA) AS AGENCIA,
                        ROUND((SUM(RESPUESTA_1)/SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END))/7*100,2) AS ASESORIA,
                        ROUND((SUM(RESPUESTA_2)/SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END))/7*100,2) AS CLARIDAD,
                        ROUND((SUM(RESPUESTA_3)/SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END))/7*100,2) AS AMABILIDAD,
                        ROUND((SUM(RESPUESTA_4)/SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END))/7*100,2) AS EMPATIA,
                        ROUND((SUM(RESPUESTA_5)/SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END))/7*100,2) AS EFECTIVIDAD,
                        ROUND((SUM(RESPUESTA_6)/SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END))/7*100,2) AS PERSONALIZACION,
                        ROUND((SUM(RESPUESTA_7)/SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*100,2) AS AGILIDAD,
                        ROUND((SUM(RESPUESTA_8)/(SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE 1 END) - SUM(CASE WHEN RESPUESTA_8 = 'NO APLICA' THEN 1 ELSE 0 END)))/7*100,2) AS ACCESIBILIDAD,
                        ROUND((
                            IFNULL(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                                    +
                                    SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END))
                                    /
                                    (SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                                    +
                                    SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)))/7*0.17,0)
                                    +
                            IFNULL(((SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END) 
                                    + 
                                    SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END))
                                    /
                                    (SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)
                                    +
                                    SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)))/7*0.25,0)
                                    +
                            IFNULL(((SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                                    +
                                    SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                                    /
                                    (SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                                    +
                                    SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)))/7*0.21,0)
                                    +
                                    (SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)
                                    /
                                    SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*0.17)
                           /0.8*100,2) as VISION
                FROM bgr.TMP1 G
                WHERE ResultLevel1 LIKE 'CU1%'
                GROUP BY AGENCIA;";
        }
        return ejecutarConsulta($sql);
        ejecutarConsulta("DROP TABLE BGR.TMP, BGR.TMP1");
    }
    
    function reportPilares($agencias, $txtRegion, $txtAgencia, $txtTipoCliente, $txtFechaInicio, $txtFechaFin, $txtArea, $txtSeccion) { //mostrar todos los registros
        $valor_array = explode(',', $agencias); //explode convierte string a array e implode convierte array a string
        $longitud = count($valor_array);
        for ($i = 0; $i < $longitud; $i++) {
            $vAgencia = trim($valor_array[$i]);
            if ($vAgencia == '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else if ($vAgencia != '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA = '$vAgencia'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else if ($vAgencia == '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else if ($vAgencia != '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA = '$vAgencia'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            }
        }
        if (($txtFechaInicio == '' || $txtFechaFin == '') && $txtAgencia == '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA LIKE '$txtAgencia%' 
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%' 
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio == '' || $txtFechaFin == '') && $txtAgencia != '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA = '$txtAgencia'
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio != '' && $txtFechaFin != '') && $txtAgencia != '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA = '$txtAgencia'
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%' 
                            AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio != '' && $txtFechaFin != '') && $txtAgencia == '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA LIKE '$txtAgencia%'
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%' 
                            AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        }
        if($txtSeccion == 'CAJAS' || $txtSeccion == 'Cajas'){
            $sql = "SELECT 
                        UPPER(AGENCIA) AS AGENCIA,
                        ROUND(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS COMUNICACION,        
                        ROUND(((SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END)
                        +
                        SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS SERVICIO,
                        ROUND(((SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                        +
                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS PERSONALIZACION,
			ROUND((SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)/SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*100,2) AS PROCESOS,
			ROUND((SUM(RESPUESTA_8)/(SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE 1 END) - SUM(CASE WHEN RESPUESTA_8 = 'NO APLICA' THEN 1 ELSE 0 END)))/7*100,2) AS DIGITAL,
			ROUND((
                        IFNULL(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                                +
                                SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END))
                                /
                                (SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                                +
                                SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)))/7*0.17,0)
                                +
                        IFNULL(((SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END) 
                                + 
                                SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END))
                                /
                                (SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)
                                +
                                SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)))/7*0.25,0)
                                +
                        IFNULL(((SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                                +
                                SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                                /
                                (SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                                +
                                SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)))/7*0.21,0)
                                +
                                (SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)
                                /
                                SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*0.17)
                        /CASE WHEN SECCION = 'CAJAS' THEN 0.42 ELSE 0.8 END *100,2) as VISION
            FROM bgr.TMP1 G
            WHERE ResultLevel1 LIKE 'CU1%' AND SECCION = 'CAJAS'
            GROUP BY AGENCIA;";
        } else {
            $sql = "SELECT 
                        UPPER(AGENCIA)  AS AGENCIA,
                        ROUND(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS COMUNICACION,     
                        ROUND(((SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END)
                        +
                        SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS SERVICIO,
                        ROUND(((SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                        +
                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS PERSONALIZACION,
                        ROUND((SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)/SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*100,2) AS PROCESOS,
                        ROUND((SUM(RESPUESTA_8)/(SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE 1 END) - SUM(CASE WHEN RESPUESTA_8 = 'NO APLICA' THEN 1 ELSE 0 END)))/7*100,2) AS DIGITAL,
                        ROUND((
                        IFNULL(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                                +
                                SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END))
                                /
                                (SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                                +
                                SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)))/7*0.17,0)
                                +
                        IFNULL(((SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END) 
                                + 
                                SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END))
                                /
                                (SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)
                                +
                                SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)))/7*0.25,0)
                                +
                        IFNULL(((SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                                +
                                SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                                /
                                (SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                                +
                                SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)))/7*0.21,0)
                                +
                                (SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)
                                /
                                SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*0.17)
                        /0.8*100,2) as VISION
                FROM bgr.TMP1 G
                WHERE ResultLevel1 LIKE 'CU1%'
                GROUP BY AGENCIA;";
        }
        return ejecutarConsulta($sql);
        ejecutarConsulta("DROP TABLE BGR.TMP, BGR.TMP1");
    }
    
    function reportLealtad($agencias, $txtRegion, $txtAgencia, $txtTipoCliente, $txtFechaInicio, $txtFechaFin, $txtArea, $txtSeccion) { //mostrar todos los registros
        $valor_array = explode(',', $agencias); //explode convierte string a array e implode convierte array a string
        $longitud = count($valor_array);
        for ($i = 0; $i < $longitud; $i++) {
            $vAgencia = trim($valor_array[$i]);
            if ($vAgencia == '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else if ($vAgencia != '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA = '$vAgencia'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else if ($vAgencia == '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else if ($vAgencia != '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA = '$vAgencia'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            }
        }

        if (($txtFechaInicio == '' || $txtFechaFin == '') && $txtAgencia == '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA LIKE '$txtAgencia%' 
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%' 
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio == '' || $txtFechaFin == '') && $txtAgencia != '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA = '$txtAgencia'
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio != '' && $txtFechaFin != '') && $txtAgencia != '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA = '$txtAgencia'
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%' 
                            AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio != '' && $txtFechaFin != '') && $txtAgencia == '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA LIKE '$txtAgencia%'
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%' 
                            AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        }
        $sql = "SELECT 
                    UPPER(AGENCIA) AS AGENCIA,
                    (SELECT 
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                                WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                                WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                    END)/count(RESPUESTA_9))*100,2) 
                    FROM BGR.TMP1 g1 WHERE g1.AGENCIA = g.AGENCIA
                    AND ResultLevel1 LIKE 'CU1%') AS INS,
                    (SELECT 
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_10 = 'MUY FACIL' THEN 0
                                WHEN RESPUESTA_10 = 'POCO FACIL' THEN 1
                                WHEN RESPUESTA_10 = 'FACIL' THEN 0
                                WHEN RESPUESTA_10 = 'DIFICIL' THEN 1
                                WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 1
                    END)/count(RESPUESTA_10))*100,2) 
                    FROM BGR.TMP1 g1 WHERE g1.AGENCIA = g.AGENCIA
                    AND ResultLevel1 LIKE 'CU1%') AS CES,
                    (SELECT
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                                WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                                WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                    END)/count(RESPUESTA_11))*100,2)
                    FROM BGR.TMP1 g1 WHERE g1.AGENCIA = g.AGENCIA
                    AND ResultLevel1 LIKE 'CU1%') AS NPS,
                    (SELECT
                    COUNT(AGENCIA)
                    FROM BGR.TMP1 g1 WHERE g1.AGENCIA = g.AGENCIA
                    AND ResultLevel1 LIKE 'CU1%') as MUESTRA,
                    (SELECT
                        ROUND(
                        (((SELECT 
                        ROUND((SUM(CASE 
                                    WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                                    WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                                    WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                        END)/count(RESPUESTA_9))*100,2) 
                        FROM BGR.TMP1 g1 WHERE g1.AGENCIA = g.AGENCIA
                        AND ResultLevel1 LIKE 'CU1%')*40)
                        +
                        ((SELECT 
                        ROUND((1-SUM(CASE 
                                    WHEN RESPUESTA_10 = 'MUY FACIL' THEN 0
                                    WHEN RESPUESTA_10 = 'POCO FACIL' THEN 1
                                    WHEN RESPUESTA_10 = 'FACIL' THEN 0
                                    WHEN RESPUESTA_10 = 'DIFICIL' THEN 1
                                    WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 1
                        END)/count(RESPUESTA_10))*100,2)
                        FROM BGR.TMP1 g1 WHERE g1.AGENCIA = g.AGENCIA
                        AND ResultLevel1 LIKE 'CU1%')*30)
                        +
                        ((SELECT
                        ROUND((SUM(CASE 
                                    WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                                    WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                                    WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                        END)/count(RESPUESTA_11))*100,2)
                        FROM BGR.TMP1 g1 WHERE g1.AGENCIA = g.AGENCIA
                        AND ResultLevel1 LIKE 'CU1%')*30)
                        )/100,2)
                    FROM BGR.TMP1 g1 WHERE g1.AGENCIA = g.AGENCIA
                    AND ResultLevel1 LIKE 'CU1%' LIMIT 1) AS LEALTAD
                FROM bgr.TMP1 G 
                WHERE ResultLevel1 LIKE 'CU1%'
                group by AGENCIA;";
        return ejecutarConsulta($sql);
        ejecutarConsulta("DROP TABLE BGR.TMP, BGR.TMP1;");
    }
    
    function reportResultados($agencias, $txtRegion, $txtAgencia, $txtTipoCliente, $txtFechaInicio, $txtFechaFin, $txtArea, $txtSeccion) { //mostrar todos los registros
        $valor_array = explode(',', $agencias); //explode convierte string a array e implode convierte array a string
        $longitud = count($valor_array);
        for ($i = 0; $i < $longitud; $i++) {
            $vAgencia = trim($valor_array[$i]);
            if ($vAgencia == '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else if ($vAgencia != '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA = '$vAgencia'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else if ($vAgencia == '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else if ($vAgencia != '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA = '$vAgencia'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            }
        }
        if (($txtFechaInicio == '' || $txtFechaFin == '') && $txtAgencia == '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA LIKE '$txtAgencia%' 
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%' 
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio == '' || $txtFechaFin == '') && $txtAgencia != '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA = '$txtAgencia'
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio != '' && $txtFechaFin != '') && $txtAgencia != '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA = '$txtAgencia'
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%' 
                            AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio != '' && $txtFechaFin != '') && $txtAgencia == '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE 
                            REGION like '%$txtRegion%' 
                            AND TIPO_CLIENTE LIKE '%$txtTipoCliente%' 
                            AND AGENCIA LIKE '$txtAgencia%'
                            AND AREA LIKE '%$txtArea%' 
                            AND SECCION LIKE '%$txtSeccion%' 
                            AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        }
        if($txtSeccion == 'CAJAS' || $txtSeccion == 'Cajas'){
            $sql = "SELECT 
                        UPPER(AGENCIA) AS AGENCIA,
                        ROUND(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS COMUNICACION,        
                        ROUND(((SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END)
                        +
                        SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS SERVICIO,
                        ROUND(((SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                        +
                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS PERSONALIZACION,
			ROUND((SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)/SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*100,2) AS PROCESOS,
			ROUND((SUM(RESPUESTA_8)/(SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE 1 END) - SUM(CASE WHEN RESPUESTA_8 = 'NO APLICA' THEN 1 ELSE 0 END)))/7*100,2) AS DIGITAL,
			ROUND((
                        IFNULL(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                                +
                                SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END))
                                /
                                (SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                                +
                                SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)))/7*0.17,0)
                                +
                        IFNULL(((SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END) 
                                + 
                                SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END))
                                /
                                (SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)
                                +
                                SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)))/7*0.25,0)
                                +
                        IFNULL(((SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                                +
                                SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                                /
                                (SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                                +
                                SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)))/7*0.21,0)
                                +
                                (SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)
                                /
                                SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*0.17)
                        /CASE WHEN SECCION = 'CAJAS' THEN 0.42 ELSE 0.8 END *100,2) as VISION
            FROM bgr.TMP1 G
            WHERE ResultLevel1 LIKE 'CU1%' AND SECCION = 'CAJAS'
            GROUP BY AGENCIA;";
        } else {
            $sql = "SELECT 
                        UPPER(AGENCIA)  AS AGENCIA,
                        ROUND(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS COMUNICACION,     
                        ROUND(((SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END)
                        +
                        SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS SERVICIO,
                        ROUND(((SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                        +
                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS PERSONALIZACION,
                        ROUND((SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)/SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*100,2) AS PROCESOS,
                        ROUND((SUM(RESPUESTA_8)/(SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE 1 END) - SUM(CASE WHEN RESPUESTA_8 = 'NO APLICA' THEN 1 ELSE 0 END)))/7*100,2) AS DIGITAL,
                        ROUND((
                        IFNULL(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                                +
                                SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END))
                                /
                                (SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                                +
                                SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)))/7*0.17,0)
                                +
                        IFNULL(((SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END) 
                                + 
                                SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END))
                                /
                                (SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)
                                +
                                SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)))/7*0.25,0)
                                +
                        IFNULL(((SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                                +
                                SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                                /
                                (SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                                +
                                SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)))/7*0.21,0)
                                +
                                (SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)
                                /
                                SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*0.17)
                        /0.8*100,2) as VISION
                FROM bgr.TMP1 G
                WHERE ResultLevel1 LIKE 'CU1%'
                GROUP BY AGENCIA;";
        }
        return ejecutarConsulta($sql);
        ejecutarConsulta("DROP TABLE BGR.TMP, BGR.TMP1");
    }
}

?>