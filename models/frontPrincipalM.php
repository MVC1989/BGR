<?php

require '../config/connection.php';

Class frontPrincipal {

    public function _construct() { /* Constructor */
    }

    function selectAllLealtad($agencias) { //mostrar todos los registros
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
        $sql = "SELECT 
                    UPPER(SECCION) AS SECCION,
                    (SELECT 
                    ROUND((SUM(CASE 
                            WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                            WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                    WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                END)/count(RESPUESTA_9))*100,2) 
                FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                AND ResultLevel1 LIKE 'CU1%') AS INS,
                (SELECT 
                ROUND((SUM(CASE 
                            WHEN RESPUESTA_10 = 'MUY FACIL' THEN 0
                    WHEN RESPUESTA_10 = 'POCO FACIL' THEN 1
                    WHEN RESPUESTA_10 = 'FACIL' THEN 0
                    WHEN RESPUESTA_10 = 'DIFICIL' THEN 1
                    WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 1
                END)/count(RESPUESTA_10))*100,2) 
                FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                AND ResultLevel1 LIKE 'CU1%') AS CES,
                (SELECT
                ROUND((SUM(CASE 
                            WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                            WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                    WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                END)/count(RESPUESTA_11))*100,2)
                FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                AND ResultLevel1 LIKE 'CU1%') AS NPS,
                (SELECT
                COUNT(SECCION)
                FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                AND ResultLevel1 LIKE 'CU1%') as MUESTRA,
                (SELECT
                    ROUND(
                    (((SELECT 
                    ROUND((SUM(CASE 
                            WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                            WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                            WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                    END)/count(RESPUESTA_9))*100,2) 
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
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
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                    AND ResultLevel1 LIKE 'CU1%')*30)
                    +
                    ((SELECT
                    ROUND((SUM(CASE 
                            WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                            WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                            WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                    END)/count(RESPUESTA_11))*100,2)
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                    AND ResultLevel1 LIKE 'CU1%')*30)
                    )/100,2)
                FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                AND ResultLevel1 LIKE 'CU1%' LIMIT 1) AS LEALTAD
            FROM bgr.TMP G 
            WHERE ResultLevel1 LIKE 'CU1%'
            group by SECCION
            UNION ALL
            SELECT
                    'TOTAL',
                ROUND((SUM(CASE 
                            WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                            WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                    WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                END)/count(RESPUESTA_9))*100,2)  AS INS,
                ROUND((SUM(CASE 
                    WHEN RESPUESTA_10 = 'MUY FACIL' THEN 0
                    WHEN RESPUESTA_10 = 'POCO FACIL' THEN 1
                    WHEN RESPUESTA_10 = 'FACIL' THEN 0
                    WHEN RESPUESTA_10 = 'DIFICIL' THEN 1
                    WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 1
                END)/count(RESPUESTA_10))*100,2)  AS CES,
                ROUND((SUM(CASE 
                            WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                            WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                    WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                END)/count(RESPUESTA_11))*100,2) AS NPS,
                COUNT(SECCION) AS MUESTRA,
                ROUND((((SUM(CASE 
                            WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                            WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                            WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                END)/count(RESPUESTA_9))*0.40)
                +
                ((1-SUM(CASE 
                    WHEN RESPUESTA_10 = 'MUY FACIL' THEN 0
                    WHEN RESPUESTA_10 = 'POCO FACIL' THEN 1
                    WHEN RESPUESTA_10 = 'FACIL' THEN 0
                    WHEN RESPUESTA_10 = 'DIFICIL' THEN 1
                    WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 1
                END)/count(RESPUESTA_10))*0.30)
                +
                ((SUM(CASE 
                        WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                        WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                        WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                END)/count(RESPUESTA_11))*0.30))*100,2) AS LEALTAD
            FROM bgr.TMP G
            WHERE ResultLevel1 LIKE 'CU1%';";
        return ejecutarConsulta($sql);
        ejecutarConsulta("DROP TABLE BGR.TMP");
    }

    function selectAllLealtadFiltros($agencias, $txtRegion, $txtAgencia, $txtTipoCliente, $txtFechaInicio, $txtFechaFin, $txtArea, $txtSeccion) { //mostrar todos los registros
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
                    UPPER(SECCION) AS SECCION,
                    (SELECT 
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                                WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                                WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                        END)/count(RESPUESTA_9))*100,2) 
                        FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion
                        AND ResultLevel1 LIKE 'CU1%') AS INS,
                    (SELECT 
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_10 = 'MUY FACIL' THEN 0
                                WHEN RESPUESTA_10 = 'POCO FACIL' THEN 1
                                WHEN RESPUESTA_10 = 'FACIL' THEN 0
                                WHEN RESPUESTA_10 = 'DIFICIL' THEN 1
                                WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 1
                    END)/count(RESPUESTA_10))*100,2) 
                    FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion
                    AND ResultLevel1 LIKE 'CU1%') AS CES,
                    (SELECT
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                                WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                                WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                    END)/count(RESPUESTA_11))*100,2)
                    FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion
                    AND ResultLevel1 LIKE 'CU1%') AS NPS,
                    (SELECT
                    COUNT(SECCION)
                    FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion
                    AND ResultLevel1 LIKE 'CU1%') as MUESTRA,
                    (SELECT
                        ROUND(
                        (((SELECT 
                        ROUND((SUM(CASE 
                                WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                                WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                                WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                        END)/count(RESPUESTA_9))*100,2) 
                        FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion
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
                        FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion
                        AND ResultLevel1 LIKE 'CU1%')*30)
                        +
                        ((SELECT
                        ROUND((SUM(CASE 
                                WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                                WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                                WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                        END)/count(RESPUESTA_11))*100,2)
                        FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion
                        AND ResultLevel1 LIKE 'CU1%')*30)
                        )/100,2)
                    FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion
                    AND ResultLevel1 LIKE 'CU1%' LIMIT 1) AS LEALTAD
                FROM bgr.TMP1 G 
                WHERE ResultLevel1 LIKE 'CU1%'
                group by SECCION
                UNION ALL
                SELECT
                    'TOTAL' AS SECCION,
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                                WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                                WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                    END)/count(RESPUESTA_9))*100,2)  AS INS,
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_10 = 'MUY FACIL' THEN 0
                                WHEN RESPUESTA_10 = 'POCO FACIL' THEN 1
                                WHEN RESPUESTA_10 = 'FACIL' THEN 0
                                WHEN RESPUESTA_10 = 'DIFICIL' THEN 1
                                WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 1
                    END)/count(RESPUESTA_10))*100,2)  AS CES,
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                                WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                                WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                    END)/count(RESPUESTA_11))*100,2) AS NPS,
                    COUNT(SECCION) AS MUESTRA,
                    ROUND((((SUM(CASE 
                                WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                                WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                                WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                    END)/count(RESPUESTA_9))*0.40)
                    +
                    ((1-SUM(CASE 
                                WHEN RESPUESTA_10 = 'MUY FACIL' THEN 0
                                WHEN RESPUESTA_10 = 'POCO FACIL' THEN 1
                                WHEN RESPUESTA_10 = 'FACIL' THEN 0
                                WHEN RESPUESTA_10 = 'DIFICIL' THEN 1
                                WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 1
                    END)/count(RESPUESTA_10))*0.30)
                    +
                    ((SUM(CASE 
                                WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                                WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                                WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                    END)/count(RESPUESTA_11))*0.30))*100,2) AS LEALTAD
                FROM bgr.TMP1 G
                WHERE ResultLevel1 LIKE 'CU1%';";
        return ejecutarConsulta($sql);
        ejecutarConsulta("DROP TABLE BGR.TMP, BGR.TMP1");
    }

    function selectAllLealtadNegocios($agencias) { //mostrar todos los registros
        $valor_array = explode(',', $agencias); //explode convierte string a array e implode convierte array a string
        $longitud = count($valor_array);
        for ($i = 0; $i < $longitud; $i++) {
            $vAgencia = trim($valor_array[$i]);
            if ($vAgencia == '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%' AND AREA = 'NEGOCIOS');");
            } else if ($vAgencia != '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA = '$vAgencia'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%' AND AREA = 'NEGOCIOS');");
            } else if ($vAgencia == '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%' AND AREA = 'NEGOCIOS');");
            } else if ($vAgencia != '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA = '$vAgencia'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%' AND AREA = 'NEGOCIOS');");
            }
        }
        $sql = "SELECT 
                    UPPER(SECCION) AS SECCION,
                    (SELECT 
                        ROUND((SUM(CASE 
                                WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                                WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                                WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                    END)/count(RESPUESTA_9))*100,2) 
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                    AND ResultLevel1 LIKE 'CU1%') AS INS,
                    (SELECT 
                        ROUND((SUM(CASE 
                                    WHEN RESPUESTA_10 = 'MUY FACIL' THEN 0
                                    WHEN RESPUESTA_10 = 'POCO FACIL' THEN 1
                                    WHEN RESPUESTA_10 = 'FACIL' THEN 0
                                    WHEN RESPUESTA_10 = 'DIFICIL' THEN 1
                                    WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 1
                        END)/count(RESPUESTA_10))*100,2) 
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                    AND ResultLevel1 LIKE 'CU1%') AS CES,
                    (SELECT
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                                WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                                WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                    END)/count(RESPUESTA_11))*100,2)
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                    AND ResultLevel1 LIKE 'CU1%') AS NPS,
                    (SELECT
                    COUNT(SECCION)
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                    AND ResultLevel1 LIKE 'CU1%') as MUESTRA,
                    (SELECT
                        ROUND(
                        (((SELECT 
                        ROUND((SUM(CASE 
                                WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                                WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                                WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                        END)/count(RESPUESTA_9))*100,2) 
                        FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
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
                        FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                        AND ResultLevel1 LIKE 'CU1%')*30)
                        +
                        ((SELECT
                        ROUND((SUM(CASE 
                                WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                                WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                                WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                        END)/count(RESPUESTA_11))*100,2)
                        FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                        AND ResultLevel1 LIKE 'CU1%')*30)
                        )/100,2)
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                    AND ResultLevel1 LIKE 'CU1%' LIMIT 1) AS LEALTAD
            FROM bgr.TMP G
            WHERE ResultLevel1 LIKE 'CU1%'
            group by SECCION
            UNION ALL
            SELECT
                    'TOTAL',
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                                WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                                WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                    END)/count(RESPUESTA_9))*100,2)  AS INS,
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_10 = 'MUY FACIL' THEN 0
                                WHEN RESPUESTA_10 = 'POCO FACIL' THEN 1
                                WHEN RESPUESTA_10 = 'FACIL' THEN 0
                                WHEN RESPUESTA_10 = 'DIFICIL' THEN 1
                                WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 1
                    END)/count(RESPUESTA_10))*100,2)  AS CES,
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                                WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                                WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                    END)/count(RESPUESTA_11))*100,2) AS NPS,
                    COUNT(SECCION) AS MUESTRA,
                    ROUND((((SUM(CASE 
                                WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                                WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                                WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                    END)/count(RESPUESTA_9))*0.40)
                    +
                    ((1-SUM(CASE 
                                WHEN RESPUESTA_10 = 'MUY FACIL' THEN 0
                                WHEN RESPUESTA_10 = 'POCO FACIL' THEN 1
                                WHEN RESPUESTA_10 = 'FACIL' THEN 0
                                WHEN RESPUESTA_10 = 'DIFICIL' THEN 1
                                WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 1
                    END)/count(RESPUESTA_10))*0.30)
                    +
                    ((SUM(CASE 
                                WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                                WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                                WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                    END)/count(RESPUESTA_11))*0.30))*100,2) AS LEALTAD
            FROM bgr.TMP G
            WHERE ResultLevel1 LIKE 'CU1%';";
        return ejecutarConsulta($sql);
        ejecutarConsulta("DROP TABLE BGR.TMP");
    }
    
    function selectAllLealtadServicios($agencias) { //mostrar todos los registros
        $valor_array = explode(',', $agencias); //explode convierte string a array e implode convierte array a string
        $longitud = count($valor_array);
        for ($i = 0; $i < $longitud; $i++) {
            $vAgencia = trim($valor_array[$i]);
            if ($vAgencia == '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%' AND AREA = 'SERVICIOS');");
            } else if ($vAgencia != '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA = '$vAgencia'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%' AND AREA = 'SERVICIOS');");
            } else if ($vAgencia == '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%' AND AREA = 'SERVICIOS');");
            } else if ($vAgencia != '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA = '$vAgencia'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%' AND AREA = 'SERVICIOS');");
            }
        }
        $sql = "SELECT 
                    UPPER(SECCION) AS SECCION,
                    (SELECT 
                    ROUND((SUM(CASE 
                            WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                            WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                            WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                END)/count(RESPUESTA_9))*100,2) 
                FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                AND ResultLevel1 LIKE 'CU1%') AS INS,
                (SELECT 
                    ROUND((SUM(CASE 
                            WHEN RESPUESTA_10 = 'MUY FACIL' THEN 0
                            WHEN RESPUESTA_10 = 'POCO FACIL' THEN 1
                            WHEN RESPUESTA_10 = 'FACIL' THEN 0
                            WHEN RESPUESTA_10 = 'DIFICIL' THEN 1
                            WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 1
                    END)/count(RESPUESTA_10))*100,2) 
                FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                AND ResultLevel1 LIKE 'CU1%') AS CES,
                (SELECT
                    ROUND((SUM(CASE 
                            WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                            WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                            WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                    END)/count(RESPUESTA_11))*100,2)
                FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                AND ResultLevel1 LIKE 'CU1%') AS NPS,
                (SELECT
                    COUNT(SECCION)
                FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                AND ResultLevel1 LIKE 'CU1%') as MUESTRA,
                (SELECT
                    ROUND(
                    (((SELECT 
                    ROUND((SUM(CASE 
                            WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                            WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                            WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                    END)/count(RESPUESTA_9))*100,2) 
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
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
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                    AND ResultLevel1 LIKE 'CU1%')*30)
                    +
                    ((SELECT
                    ROUND((SUM(CASE 
                            WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                            WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                            WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                    END)/count(RESPUESTA_11))*100,2)
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                    AND ResultLevel1 LIKE 'CU1%')*30)
                    )/100,2)
                FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                AND ResultLevel1 LIKE 'CU1%' LIMIT 1) AS LEALTAD
            FROM bgr.TMP G
            WHERE ResultLevel1 LIKE 'CU1%'
            group by SECCION
            UNION ALL
            SELECT
                'TOTAL',
                ROUND((SUM(CASE 
                            WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                            WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                            WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                END)/count(RESPUESTA_9))*100,2)  AS INS,
                ROUND((SUM(CASE 
                            WHEN RESPUESTA_10 = 'MUY FACIL' THEN 0
                            WHEN RESPUESTA_10 = 'POCO FACIL' THEN 1
                            WHEN RESPUESTA_10 = 'FACIL' THEN 0
                            WHEN RESPUESTA_10 = 'DIFICIL' THEN 1
                            WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 1
                END)/count(RESPUESTA_10))*100,2)  AS CES,
                ROUND((SUM(CASE 
                            WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                            WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                            WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                END)/count(RESPUESTA_11))*100,2) AS NPS,
                COUNT(SECCION) AS MUESTRA,
                ROUND((((SUM(CASE 
                            WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                            WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                            WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                END)/count(RESPUESTA_9))*0.40)
                +
                ((1-SUM(CASE 
                            WHEN RESPUESTA_10 = 'MUY FACIL' THEN 0
                            WHEN RESPUESTA_10 = 'POCO FACIL' THEN 1
                            WHEN RESPUESTA_10 = 'FACIL' THEN 0
                            WHEN RESPUESTA_10 = 'DIFICIL' THEN 1
                            WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 1
                END)/count(RESPUESTA_10))*0.30)
                +
                ((SUM(CASE 
                        WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                        WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                        WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                END)/count(RESPUESTA_11))*0.30))*100,2) AS LEALTAD
            FROM bgr.TMP G
            WHERE ResultLevel1 LIKE 'CU1%';";
        return ejecutarConsulta($sql);
        ejecutarConsulta("DROP TABLE BGR.TMP");
    }

    function selectAllPilaresServicios($agencias) { //mostrar todos los registros
        $valor_array = explode(',', $agencias); //explode convierte string a array e implode convierte array a string
        $longitud = count($valor_array);
        for ($i = 0; $i < $longitud; $i++) {
            $vAgencia = trim($valor_array[$i]);
            if ($vAgencia == '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%' AND AREA = 'SERVICIOS');");
            } else if ($vAgencia != '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA = '$vAgencia'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%' AND AREA = 'SERVICIOS');");
            } else if ($vAgencia == '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%' AND AREA = 'SERVICIOS');");
            } else if ($vAgencia != '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA = '$vAgencia'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%' AND AREA = 'SERVICIOS');");
            }
        }
        $sql = "SELECT 
                    UPPER(SECCION) AS SECCION,
                    (SELECT IF(RESPUESTA_1,
                        ROUND((SUM(RESPUESTA_1)/count(RESPUESTA_1))/7*100,2),NULL) 
                    FROM BGR.GESTIONFINAL g1 WHERE g1.seccion = g.seccion AND RESPUESTA_1 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS ASESORIA,
                    (SELECT IF(RESPUESTA_2,
                        ROUND((SUM(RESPUESTA_2)/count(RESPUESTA_2))/7*100,2),NULL)
                    FROM BGR.GESTIONFINAL g1 WHERE g1.seccion = g.seccion AND RESPUESTA_2 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS CLARIDAD,
                    (SELECT IF(RESPUESTA_3,
                        ROUND((SUM(RESPUESTA_3)/count(RESPUESTA_3))/7*100,2),NULL)
                    FROM BGR.GESTIONFINAL g1 WHERE g1.seccion = g.seccion AND RESPUESTA_3 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS AMABILIDAD,
                    (SELECT IF(RESPUESTA_4,
                        ROUND((SUM(RESPUESTA_4)/count(RESPUESTA_4))/7*100,2),NULL)
                    FROM BGR.GESTIONFINAL g1 WHERE g1.seccion = g.seccion AND RESPUESTA_4 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS EMPATIA,
                    (SELECT IF(RESPUESTA_5,
                        ROUND((SUM(RESPUESTA_5)/count(RESPUESTA_5))/7*100,2),NULL)
                    FROM BGR.GESTIONFINAL g1 WHERE g1.seccion = g.seccion AND RESPUESTA_5 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS EFECTIVIDAD,
                    (SELECT IF(RESPUESTA_6,
                        ROUND((SUM(RESPUESTA_6)/count(RESPUESTA_6))/7*100,2),NULL)
                    FROM BGR.GESTIONFINAL g1 WHERE g1.seccion = g.seccion AND RESPUESTA_6 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS PERSONALIZACION,
                    (SELECT IF(RESPUESTA_7,
                        ROUND((SUM(RESPUESTA_7)/count(RESPUESTA_7))/7*100,2),NULL)
                    FROM BGR.GESTIONFINAL g1 WHERE g1.seccion = g.seccion AND RESPUESTA_7 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS AGILIDAD,
                    (SELECT IF(RESPUESTA_8,
                        ROUND((SUM(RESPUESTA_8)/count(RESPUESTA_8))/7*100,2),NULL)
                    FROM BGR.GESTIONFINAL g1 WHERE g1.seccion = g.seccion AND RESPUESTA_8 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS ACCESIBILIDAD,
                    (SELECT 
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
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                    AND ResultLevel1 LIKE 'CU1%') AS VISION
            FROM bgr.TMP G
            WHERE ResultLevel1 LIKE 'CU1%'
            GROUP BY SECCION
            UNION ALL
            SELECT 
                'TOTAL ATRIBUTOS',
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
                FROM bgr.TMP G
                WHERE ResultLevel1 LIKE 'CU1%'
                UNION ALL
                SELECT 
                'TOTAL PILARES',
                        'TOTAL COMUNICACION',
                        ROUND(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS TC,
                        'TOTAL SERVICIOS',         
                        ROUND(((SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END)
                        +
                        SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS TS,      
                        'TOTAL PERSONALIZACION',
                        ROUND(((SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                        +
                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS TP,
                        ROUND((SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)/SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*100,2) AS TP,
                        ROUND((SUM(RESPUESTA_8)/(SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE 1 END) - SUM(CASE WHEN RESPUESTA_8 = 'NO APLICA' THEN 1 ELSE 0 END)))/7*100,2) AS TD,
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
                                SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*0.17)/0.8*100,2) as VISION
        FROM bgr.TMP G
        WHERE ResultLevel1 LIKE 'CU1%';";
        return ejecutarConsulta($sql);
        ejecutarConsulta("DROP TABLE BGR.TMP");
    }
    
    function selectAllPilares($agencias) { //mostrar todos los registros
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
        $sql = "SELECT 
                    UPPER(SECCION) AS SECCION,
                    (SELECT IF(RESPUESTA_1,
                        ROUND((SUM(RESPUESTA_1)/count(RESPUESTA_1))/7*100,2),NULL) 
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion AND RESPUESTA_1 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS ASESORIA,
                    (SELECT IF(RESPUESTA_2,
                        ROUND((SUM(RESPUESTA_2)/count(RESPUESTA_2))/7*100,2),NULL)
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion AND RESPUESTA_2 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS CLARIDAD,
                    (SELECT IF(RESPUESTA_3,
                        ROUND((SUM(RESPUESTA_3)/count(RESPUESTA_3))/7*100,2),NULL)
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion AND RESPUESTA_3 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS AMABILIDAD,
                    (SELECT IF(RESPUESTA_4,
                        ROUND((SUM(RESPUESTA_4)/count(RESPUESTA_4))/7*100,2),NULL)
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion AND RESPUESTA_4 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS EMPATIA,
                    (SELECT IF(RESPUESTA_5,
                        ROUND((SUM(RESPUESTA_5)/count(RESPUESTA_5))/7*100,2),NULL)
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion AND RESPUESTA_5 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS EFECTIVIDAD,
                    (SELECT IF(RESPUESTA_6,
                        ROUND((SUM(RESPUESTA_6)/count(RESPUESTA_6))/7*100,2),NULL)
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion AND RESPUESTA_6 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS PERSONALIZACION,
                    (SELECT IF(RESPUESTA_7,
                        ROUND((SUM(RESPUESTA_7)/count(RESPUESTA_7))/7*100,2),NULL)
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion AND RESPUESTA_7 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS AGILIDAD,
                    (SELECT IF(RESPUESTA_8,
                        ROUND((SUM(RESPUESTA_8)/count(RESPUESTA_8))/7*100,2),NULL)
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion AND RESPUESTA_8 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS ACCESIBILIDAD,
                    (SELECT 
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
                        /
                        CASE WHEN SECCION = 'CAJAS' THEN 0.42 ELSE 0.8 END *100,2)
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                    AND ResultLevel1 LIKE 'CU1%') AS VISION
            FROM bgr.TMP G
            WHERE ResultLevel1 LIKE 'CU1%'
            GROUP BY SECCION
            UNION ALL
            SELECT 
                'TOTAL ATRIBUTOS',
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
                        /
                        0.8*100,2)as VISION
        FROM bgr.TMP G
        WHERE ResultLevel1 LIKE 'CU1%'
        UNION ALL
        SELECT 
                'TOTAL PILARES',
                'TOTAL COMUNICACION',
                ROUND(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                +
                SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END))
                /
                (
                SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                +
                SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)
                ))/7*100,2) AS TC,
                'TOTAL SERVICIOS',         
                ROUND(((SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END)
                +
                SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END))
                /
                (
                SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)
                +
                SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)
                ))/7*100,2) AS TS,      
                'TOTAL PERSONALIZACION',
                ROUND(((SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                +
                SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                /
                (
                SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                +
                SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)
                ))/7*100,2) AS TP,
                ROUND((SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)/SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*100,2) AS TP,
                ROUND((SUM(RESPUESTA_8)/(SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE 1 END) - SUM(CASE WHEN RESPUESTA_8 = 'NO APLICA' THEN 1 ELSE 0 END)))/7*100,2) AS TD,
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
                        /
                        0.8*100,2)as VISION
        FROM bgr.TMP G
        WHERE ResultLevel1 LIKE 'CU1%';";
        return ejecutarConsulta($sql);
        ejecutarConsulta("DROP TABLE BGR.TMP");
    }

    function selectAllPilaresFiltros($agencias, $txtRegion, $txtAgencia, $txtTipoCliente, $txtFechaInicio, $txtFechaFin, $txtArea, $txtSeccion) { //mostrar todos los registros
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
            $opc1 = " ";
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
            $opc1 = " ";
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
            $opc1 = " AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin' ";
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
            $opc1 = " AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin' ";
        }
        if ($txtSeccion == 'Cajas' || $txtSeccion == 'CAJAS'){
            $sql = "SELECT 
                    UPPER(SECCION) AS SECCION,
                    (SELECT IF(RESPUESTA_1,
                        ROUND((SUM(RESPUESTA_1)/count(RESPUESTA_1))/7*100,2),NULL) 
                    FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion AND RESPUESTA_1 <> ''
                    AND ResultLevel1 LIKE 'CU1%' $opc1 ) AS ASESORIA,
                    (SELECT IF(RESPUESTA_2,
                        ROUND((SUM(RESPUESTA_2)/count(RESPUESTA_2))/7*100,2),NULL)
                    FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion AND RESPUESTA_2 <> ''
                    AND ResultLevel1 LIKE 'CU1%' $opc1 ) AS CLARIDAD,
                    (SELECT IF(RESPUESTA_3,
                        ROUND((SUM(RESPUESTA_3)/count(RESPUESTA_3))/7*100,2),NULL)
                    FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion AND RESPUESTA_3 <> ''
                    AND ResultLevel1 LIKE 'CU1%' $opc1 ) AS AMABILIDAD,
                    (SELECT IF(RESPUESTA_4,
                        ROUND((SUM(RESPUESTA_4)/count(RESPUESTA_4))/7*100,2),NULL)
                    FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion AND RESPUESTA_4 <> ''
                    AND ResultLevel1 LIKE 'CU1%' $opc1 ) AS EMPATIA,
                    (SELECT IF(RESPUESTA_5,
                        ROUND((SUM(RESPUESTA_5)/count(RESPUESTA_5))/7*100,2),NULL)
                    FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion AND RESPUESTA_5 <> ''
                    AND ResultLevel1 LIKE 'CU1%' $opc1 ) AS EFECTIVIDAD,
                    (SELECT IF(RESPUESTA_6,
                        ROUND((SUM(RESPUESTA_6)/count(RESPUESTA_6))/7*100,2),NULL)
                    FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion AND RESPUESTA_6 <> ''
                    AND ResultLevel1 LIKE 'CU1%' $opc1 ) AS PERSONALIZACION,
                    (SELECT IF(RESPUESTA_7,
                        ROUND((SUM(RESPUESTA_7)/count(RESPUESTA_7))/7*100,2),NULL)
                    FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion AND RESPUESTA_7 <> ''
                    AND ResultLevel1 LIKE 'CU1%' $opc1 ) AS AGILIDAD,
                    (SELECT IF(RESPUESTA_8,
                        ROUND((SUM(RESPUESTA_8)/count(RESPUESTA_8))/7*100,2),NULL)
                    FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion AND (RESPUESTA_8 <> '' AND RESPUESTA_8 <> 'NO APLICA')
                    AND ResultLevel1 LIKE 'CU1%' $opc1 ) AS ACCESIBILIDAD,
                    (SELECT 
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
                        /
                        CASE WHEN SECCION = 'CAJAS' THEN 0.42 ELSE 0.8 END *100,2) 
                    FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion
                    AND ResultLevel1 LIKE 'CU1%') AS VISION
                FROM bgr.TMP1 G
                WHERE ResultLevel1 LIKE 'CU1%'
                GROUP BY SECCION
                UNION ALL
                SELECT 
                    'TOTAL ATRIBUTOS',
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
                        /
                        CASE WHEN SECCION = 'CAJAS' THEN 0.42 ELSE 0.8 END *100,2) as VISION
                FROM bgr.TMP1 G
                WHERE ResultLevel1 LIKE 'CU1%'
                UNION ALL
                SELECT 
                        'TOTAL PILARES',
                        'TOTAL COMUNICACION',
                        ROUND(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS TC,
                        'TOTAL SERVICIOS',         
                        ROUND(((SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END)
                        +
                        SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS TS,      
                        'TOTAL PERSONALIZACION',
                        ROUND(((SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                        +
                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS TP,
                        ROUND((SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)/SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*100,2) AS TP,
                        ROUND((SUM(RESPUESTA_8)/(SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE 1 END) - SUM(CASE WHEN RESPUESTA_8 = 'NO APLICA' THEN 1 ELSE 0 END)))/7*100,2) AS TD,
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
                WHERE ResultLevel1 LIKE 'CU1%' AND SECCION = 'CAJAS';";
        }else{
            $sql = "SELECT 
                    UPPER(SECCION) AS SECCION,
                    (SELECT IF(RESPUESTA_1,
                        ROUND((SUM(RESPUESTA_1)/count(RESPUESTA_1))/7*100,2),NULL) 
                        FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion AND RESPUESTA_1 <> ''
                        AND ResultLevel1 LIKE 'CU1%' $opc1) AS ASESORIA,
                    (SELECT IF(RESPUESTA_2,
                        ROUND((SUM(RESPUESTA_2)/count(RESPUESTA_2))/7*100,2),NULL)
                        FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion AND RESPUESTA_2 <> ''
                        AND ResultLevel1 LIKE 'CU1%' $opc1) AS CLARIDAD,
                    (SELECT IF(RESPUESTA_3,
                        ROUND((SUM(RESPUESTA_3)/count(RESPUESTA_3))/7*100,2),NULL)
                        FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion AND RESPUESTA_3 <> ''
                        AND ResultLevel1 LIKE 'CU1%' $opc1) AS AMABILIDAD,
                    (SELECT IF(RESPUESTA_4,
                        ROUND((SUM(RESPUESTA_4)/count(RESPUESTA_4))/7*100,2),NULL)
                        FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion AND RESPUESTA_4 <> ''
                        AND ResultLevel1 LIKE 'CU1%' $opc1) AS EMPATIA,
                    (SELECT IF(RESPUESTA_5,
                        ROUND((SUM(RESPUESTA_5)/count(RESPUESTA_5))/7*100,2),NULL)
                        FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion AND RESPUESTA_5 <> ''
                        AND ResultLevel1 LIKE 'CU1%' $opc1) AS EFECTIVIDAD,
                    (SELECT IF(RESPUESTA_6,
                        ROUND((SUM(RESPUESTA_6)/count(RESPUESTA_6))/7*100,2),NULL)
                        FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion AND RESPUESTA_6 <> ''
                        AND ResultLevel1 LIKE 'CU1%' $opc1) AS PERSONALIZACION,
                    (SELECT IF(RESPUESTA_7,
                        ROUND((SUM(RESPUESTA_7)/count(RESPUESTA_7))/7*100,2),NULL)
                        FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion AND RESPUESTA_7 <> ''
                        AND ResultLevel1 LIKE 'CU1%' $opc1) AS AGILIDAD,
                    (SELECT IF(RESPUESTA_8,
                        ROUND((SUM(RESPUESTA_8)/count(RESPUESTA_8))/7*100,2),NULL)
                        FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion AND (RESPUESTA_8 <> '' AND RESPUESTA_8 <> 'NO APLICA')
                        AND ResultLevel1 LIKE 'CU1%' $opc1) AS ACCESIBILIDAD,
                    (SELECT 
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
                        FROM BGR.TMP1 g1 WHERE g1.seccion = g.seccion
                        AND ResultLevel1 LIKE 'CU1%') AS VISION
                FROM bgr.TMP1 G
                WHERE ResultLevel1 LIKE 'CU1%'
                GROUP BY SECCION
                UNION ALL
                SELECT 
                    'TOTAL ATRIBUTOS',
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
                UNION ALL
                SELECT 
                        'TOTAL PILARES',
                        'TOTAL COMUNICACION',
                        ROUND(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS TC,
                        'TOTAL SERVICIOS',         
                        ROUND(((SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END)
                        +
                        SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS TS,      
                        'TOTAL PERSONALIZACION',
                        ROUND(((SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                        +
                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS TP,
                        ROUND((SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)/SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*100,2) AS TP,
                        ROUND((SUM(RESPUESTA_8)/(SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE 1 END) - SUM(CASE WHEN RESPUESTA_8 = 'NO APLICA' THEN 1 ELSE 0 END)))/7*100,2) AS TD,
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
                WHERE ResultLevel1 LIKE 'CU1%';";
        }
        return ejecutarConsulta($sql);
        ejecutarConsulta("DROP TABLE BGR.TMP, BGR.TMP1");
    }

    function selectAllPilaresNegocios($agencias) { //mostrar todos los registros
        $valor_array = explode(',', $agencias); //explode convierte string a array e implode convierte array a string
        $longitud = count($valor_array);
        for ($i = 0; $i < $longitud; $i++) {
            $vAgencia = trim($valor_array[$i]);
            if ($vAgencia == '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%' AND AREA = 'NEGOCIOS');");
            } else if ($vAgencia != '' && $i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA = '$vAgencia'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%' AND AREA = 'NEGOCIOS');");
            } else if ($vAgencia == '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%' AND AREA = 'NEGOCIOS');");
            } else if ($vAgencia != '' && $i > 0) {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA = '$vAgencia'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%' AND AREA = 'NEGOCIOS');");
            }
        }
        $sql = "SELECT 
                    UPPER(SECCION) AS SECCION,
                    (SELECT IF(RESPUESTA_1,
                        ROUND((SUM(RESPUESTA_1)/count(RESPUESTA_1))/7*100,2),NULL) 
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion AND RESPUESTA_1 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS ASESORIA,
                    (SELECT IF(RESPUESTA_2,
                        ROUND((SUM(RESPUESTA_2)/count(RESPUESTA_2))/7*100,2),NULL)
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion AND RESPUESTA_2 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS CLARIDAD,
                    (SELECT IF(RESPUESTA_3,
                        ROUND((SUM(RESPUESTA_3)/count(RESPUESTA_3))/7*100,2),NULL)
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion AND RESPUESTA_3 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS AMABILIDAD,
                    (SELECT IF(RESPUESTA_4,
                        ROUND((SUM(RESPUESTA_4)/count(RESPUESTA_4))/7*100,2),NULL)
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion AND RESPUESTA_4 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS EMPATIA,
                    (SELECT IF(RESPUESTA_5,
                        ROUND((SUM(RESPUESTA_5)/count(RESPUESTA_5))/7*100,2),NULL)
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion AND RESPUESTA_5 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS EFECTIVIDAD,
                    (SELECT IF(RESPUESTA_6,
                        ROUND((SUM(RESPUESTA_6)/count(RESPUESTA_6))/7*100,2),NULL)
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion AND RESPUESTA_6 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS PERSONALIZACION,
                    (SELECT IF(RESPUESTA_7,
                        ROUND((SUM(RESPUESTA_7)/count(RESPUESTA_7))/7*100,2),NULL)
                    FROM BGR.GESTIONFINAL g1 WHERE g1.seccion = g.seccion AND RESPUESTA_7 <> ''
                    AND ResultLevel1 LIKE 'CU1%') AS AGILIDAD,
                    (SELECT IF(RESPUESTA_8,
                        ROUND((SUM(RESPUESTA_8)/count(RESPUESTA_8))/7*100,2),NULL)
                    FROM BGR.GESTIONFINAL g1 WHERE g1.seccion = g.seccion AND (RESPUESTA_8 <> '' AND RESPUESTA_8 <> 'NO APLICA')
                    AND ResultLevel1 LIKE 'CU1%') AS ACCESIBILIDAD,
                    (SELECT 
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
                            /
                            CASE WHEN SECCION = 'CAJAS' THEN 0.42 ELSE 0.8 END *100,2) 
                    FROM BGR.TMP g1 WHERE g1.seccion = g.seccion
                    AND ResultLevel1 LIKE 'CU1%') AS VISION
            FROM bgr.TMP G
            WHERE ResultLevel1 LIKE 'CU1%'
            GROUP BY SECCION
            UNION ALL
            SELECT 
                'TOTAL ATRIBUTOS',
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
        FROM bgr.TMP G
        WHERE ResultLevel1 LIKE 'CU1%'
        UNION ALL
        SELECT 
                'TOTAL PILARES',
                        'TOTAL COMUNICACION',
                        ROUND(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS TC,
                        'TOTAL SERVICIOS',         
                        ROUND(((SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END)
                        +
                        SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS TS,      
                        'TOTAL PERSONALIZACION',
                        ROUND(((SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                        +
                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS TP,
                        ROUND((SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)/SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*100,2) AS TP,
                        ROUND((SUM(RESPUESTA_8)/(SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE 1 END) - SUM(CASE WHEN RESPUESTA_8 = 'NO APLICA' THEN 1 ELSE 0 END)))/7*100,2) AS TD,
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
        FROM bgr.TMP G
        WHERE ResultLevel1 LIKE 'CU1%';";
        return ejecutarConsulta($sql);
        ejecutarConsulta("DROP TABLE BGR.TMP");
    }

}

?>