<?php

require '../config/connection.php';

Class frontCanales {

    public function _construct() { /* Constructor */
    }

    function selectAllLealtadFiltros($txtCanal, $txtFechaInicio, $txtFechaFin) { //mostrar todos los registros
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
                            WHERE SEGMENTO like '%$txtCanal%' 
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio == '' || $txtFechaFin == '') && $txtCanal != '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE SEGMENTO like '%$txtCanal%' 
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio != '' && $txtFechaFin != '') && $txtCanal != '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE SEGMENTO like '%$txtCanal%' 
                            AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        } else if (($txtFechaInicio != '' && $txtFechaFin != '') && $txtCanal == '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE SEGMENTO like '%$txtCanal%' 
                            AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
        }
        $sql = "SELECT 
                    UPPER(SEGMENTO) AS SEGMENTO,
                    (SELECT 
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_13 >= 8 AND RESPUESTA_13 <= 10 THEN 1
                                WHEN RESPUESTA_13 >= 5 AND RESPUESTA_13 <= 7 THEN 0
                                WHEN RESPUESTA_13 >= 1 AND RESPUESTA_13 <= 4 THEN -1
                        END)/count(RESPUESTA_13))*100,2) 
                        FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO
                        AND ResultLevel1 LIKE 'CU1%') AS INS,
                    (SELECT 
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_14 = 'MUY FACIL' THEN 0
                                WHEN RESPUESTA_14 = 'POCO FACIL' THEN 1
                                WHEN RESPUESTA_14 = 'FACIL' THEN 0
                                WHEN RESPUESTA_14 = 'DIFICIL' THEN 1
                                WHEN RESPUESTA_14 = 'MUY DIFICIL' THEN 1
                    END)/count(RESPUESTA_14))*100,2) 
                    FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO
                    AND ResultLevel1 LIKE 'CU1%') AS CES,
                    (SELECT
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_15 >= 9 AND RESPUESTA_15 <= 10 THEN 1
                                WHEN RESPUESTA_15 >= 7 AND RESPUESTA_15 <= 8 THEN 0
                                WHEN RESPUESTA_15 >= 0 AND RESPUESTA_15 <= 6 THEN -1
                    END)/count(RESPUESTA_15))*100,2)
                    FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO
                    AND ResultLevel1 LIKE 'CU1%') AS NPS,
                    (SELECT
                    COUNT(SEGMENTO)
                    FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO
                    AND ResultLevel1 LIKE 'CU1%') as MUESTRA,
                    (SELECT
                        ROUND(
                        (((SELECT 
                        ROUND((SUM(CASE 
                                WHEN RESPUESTA_13 >= 8 AND RESPUESTA_13 <= 10 THEN 1
                                WHEN RESPUESTA_13 >= 5 AND RESPUESTA_13 <= 7 THEN 0
                                WHEN RESPUESTA_13 >= 1 AND RESPUESTA_13 <= 4 THEN -1
                        END)/count(RESPUESTA_13))*100,2) 
                        FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO
                        AND ResultLevel1 LIKE 'CU1%')*40)
                        +
                        ((SELECT 
                        ROUND((1-SUM(CASE 
                                WHEN RESPUESTA_14 = 'MUY FACIL' THEN 0
                                WHEN RESPUESTA_14 = 'POCO FACIL' THEN 1
                                WHEN RESPUESTA_14 = 'FACIL' THEN 0
                                WHEN RESPUESTA_14 = 'DIFICIL' THEN 1
                                WHEN RESPUESTA_14 = 'MUY DIFICIL' THEN 1
                        END)/count(RESPUESTA_14))*100,2)
                        FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO
                        AND ResultLevel1 LIKE 'CU1%')*30)
                        +
                        ((SELECT
                        ROUND((SUM(CASE 
                                WHEN RESPUESTA_15 >= 9 AND RESPUESTA_15 <= 10 THEN 1
                                WHEN RESPUESTA_15 >= 7 AND RESPUESTA_15 <= 8 THEN 0
                                WHEN RESPUESTA_15 >= 0 AND RESPUESTA_15 <= 6 THEN -1
                        END)/count(RESPUESTA_15))*100,2)
                        FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO
                        AND ResultLevel1 LIKE 'CU1%')*30)
                        )/100,2)
                    FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO
                    AND ResultLevel1 LIKE 'CU1%' LIMIT 1) AS LEALTAD
                FROM bgr.TMP1 G 
                WHERE ResultLevel1 LIKE 'CU1%'
                group by SEGMENTO
                UNION ALL
                SELECT
                    'TOTAL' AS SEGMENTO,
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_13 >= 8 AND RESPUESTA_13 <= 10 THEN 1
                                WHEN RESPUESTA_13 >= 5 AND RESPUESTA_13 <= 7 THEN 0
                                WHEN RESPUESTA_13 >= 1 AND RESPUESTA_13 <= 4 THEN -1
                    END)/count(RESPUESTA_13))*100,2)  AS INS,
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_14 = 'MUY FACIL' THEN 0
                                WHEN RESPUESTA_14 = 'POCO FACIL' THEN 1
                                WHEN RESPUESTA_14 = 'FACIL' THEN 0
                                WHEN RESPUESTA_14 = 'DIFICIL' THEN 1
                                WHEN RESPUESTA_14 = 'MUY DIFICIL' THEN 1
                    END)/count(RESPUESTA_14))*100,2)  AS CES,
                    ROUND((SUM(CASE 
                                WHEN RESPUESTA_15 >= 9 AND RESPUESTA_15 <= 10 THEN 1
                                WHEN RESPUESTA_15 >= 7 AND RESPUESTA_15 <= 8 THEN 0
                                WHEN RESPUESTA_15 >= 0 AND RESPUESTA_15 <= 6 THEN -1
                    END)/count(RESPUESTA_15))*100,2) AS NPS,
                    COUNT(SEGMENTO) AS MUESTRA,
                    ROUND((((SUM(CASE 
                                WHEN RESPUESTA_13 >= 8 AND RESPUESTA_13 <= 10 THEN 1
                                WHEN RESPUESTA_13 >= 5 AND RESPUESTA_13 <= 7 THEN 0
                                WHEN RESPUESTA_13 >= 1 AND RESPUESTA_13 <= 4 THEN -1
                    END)/count(RESPUESTA_13))*0.40)
                    +
                    ((1-SUM(CASE 
                                WHEN RESPUESTA_14 = 'MUY FACIL' THEN 0
                                WHEN RESPUESTA_14 = 'POCO FACIL' THEN 1
                                WHEN RESPUESTA_14 = 'FACIL' THEN 0
                                WHEN RESPUESTA_14 = 'DIFICIL' THEN 1
                                WHEN RESPUESTA_14 = 'MUY DIFICIL' THEN 1
                    END)/count(RESPUESTA_14))*0.30)
                    +
                    ((SUM(CASE 
                                WHEN RESPUESTA_15 >= 9 AND RESPUESTA_15 <= 10 THEN 1
                                WHEN RESPUESTA_15 >= 7 AND RESPUESTA_15 <= 8 THEN 0
                                WHEN RESPUESTA_15 >= 0 AND RESPUESTA_15 <= 6 THEN -1
                    END)/count(RESPUESTA_15))*0.30))*100,2) AS LEALTAD
                FROM bgr.TMP1 G
                WHERE ResultLevel1 LIKE 'CU1%';";
        return ejecutarConsulta($sql);
        ejecutarConsulta("DROP TABLE BGR.TMP, BGR.TMP1");
    }

    function selectAllPilaresFiltros($txtCanal, $txtFechaInicio, $txtFechaFin) { //mostrar todos los registros
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
                            WHERE SEGMENTO like '%$txtCanal%' 
                            AND RESULTLEVEL1 LIKE 'CU1%');");
            $opc1 = " ";
        } else if (($txtFechaInicio == '' || $txtFechaFin == '') && $txtCanal != '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE SEGMENTO like '%$txtCanal%' 
                            AND RESULTLEVEL1 LIKE 'CU1%');");
            $opc1 = " ";
        } else if (($txtFechaInicio != '' && $txtFechaFin != '') && $txtCanal != '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE SEGMENTO like '%$txtCanal%' 
                            AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
            $opc1 = " AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin' ";
        } else if (($txtFechaInicio != '' && $txtFechaFin != '') && $txtCanal == '') {
            ejecutarConsulta("CREATE TEMPORARY TABLE BGR.TMP1 AS (
                            SELECT * FROM bgr.TMP 
                            WHERE SEGMENTO like '%$txtCanal%' 
                            AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin'
                            AND RESULTLEVEL1 LIKE 'CU1%');");
            $opc1 = " AND STR_TO_DATE(FECHA_ATENCION,'%d/%m/%Y') BETWEEN '$txtFechaInicio' AND '$txtFechaFin' ";
        }
        if ($txtCanal == 'BGR MOVIL' || $txtCanal == 'BGR NET') {
            $opc1 = '0.55 * 100';
        } else {
            $opc1 = '0.8 * 100';
        }
        $sql = "SELECT 
                    UPPER(SEGMENTO) AS SEGMENTO,
                    (SELECT IF(RESPUESTA_1,
                        ROUND((SUM(RESPUESTA_1)/count(RESPUESTA_1))/7*100,2),NULL) 
                        FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO AND RESPUESTA_1 <> ''
                        AND ResultLevel1 LIKE 'CU1%' ) AS ASESORIA,
                    (SELECT IF(RESPUESTA_2,
                        ROUND((SUM(RESPUESTA_2)/count(RESPUESTA_2))/7*100,2),NULL)
                        FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO AND RESPUESTA_2 <> ''
                        AND ResultLevel1 LIKE 'CU1%' ) AS CLARIDAD,
                    (SELECT IF(RESPUESTA_3,
                        ROUND((SUM(RESPUESTA_3)/count(RESPUESTA_3))/7*100,2),NULL)
                        FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO AND RESPUESTA_3 <> ''
                        AND ResultLevel1 LIKE 'CU1%' ) AS OPORTUNIDAD,
                    (SELECT IF(RESPUESTA_4,
                        ROUND((SUM(RESPUESTA_4)/count(RESPUESTA_4))/7*100,2),NULL)
                        FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO AND RESPUESTA_4 <> ''
                        AND ResultLevel1 LIKE 'CU1%' ) AS ACTITUD,
                    (SELECT IF(RESPUESTA_5,
                        ROUND((SUM(RESPUESTA_5)/count(RESPUESTA_5))/7*100,2),NULL)
                        FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO AND RESPUESTA_5 <> ''
                        AND ResultLevel1 LIKE 'CU1%' ) AS EMPATIA,
                    (SELECT IF(RESPUESTA_6,
                        ROUND((SUM(RESPUESTA_6)/count(RESPUESTA_6))/7*100,2),NULL)
                        FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO AND RESPUESTA_6 <> ''
                        AND ResultLevel1 LIKE 'CU1%' ) AS EFECTIVIDAD,
                    (SELECT IF(RESPUESTA_7,
                        ROUND((SUM(RESPUESTA_7)/count(RESPUESTA_7))/7*100,2),NULL)
                        FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO AND RESPUESTA_7 <> ''
                        AND ResultLevel1 LIKE 'CU1%' ) AS SOLUCION,
                    (SELECT IF(RESPUESTA_8,
                        ROUND((SUM(RESPUESTA_8)/count(RESPUESTA_8))/7*100,2),NULL)
                        FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO AND (RESPUESTA_8 <> '' AND RESPUESTA_8 <> 'NO APLICA')
                        AND ResultLevel1 LIKE 'CU1%' ) AS PROACTIVIDAD,
                    (SELECT IF(RESPUESTA_9,
                        ROUND((SUM(RESPUESTA_9)/count(RESPUESTA_9))/7*100,2),NULL)
                        FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO AND (RESPUESTA_9 <> '' AND RESPUESTA_9 <> 'NO APLICA')
                        AND ResultLevel1 LIKE 'CU1%' ) AS AGILIDAD,
                    (SELECT IF(RESPUESTA_10,
                        ROUND((SUM(RESPUESTA_10)/count(RESPUESTA_10))/7*100,2),NULL)
                        FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO AND (RESPUESTA_10 <> '' AND RESPUESTA_10 <> 'NO APLICA')
                        AND ResultLevel1 LIKE 'CU1%' ) AS FLEXIBILIDAD,
                    (SELECT IF(RESPUESTA_11,
                        ROUND((SUM(RESPUESTA_11)/count(RESPUESTA_11))/7*100,2),NULL)
                        FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO AND RESPUESTA_11 <> ''
                        AND ResultLevel1 LIKE 'CU1%' ) AS ACCESIBILIDAD,
                    (SELECT IF(RESPUESTA_12,
                        ROUND((SUM(RESPUESTA_12)/count(RESPUESTA_12))/7*100,2),NULL)
                        FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO AND RESPUESTA_12 <> ''
                        AND ResultLevel1 LIKE 'CU1%' ) AS INNOVACION,
                    (SELECT 
                        ROUND((
                        IFNULL(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END))
                                        /
                                        (SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)))/7*0.17,0)
                                        +
                        IFNULL(((SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END) 
                                        + 
                                        SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                                        /
                                        (SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)))/7*0.25,0)
                                        +
                        IFNULL(((SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE RESPUESTA_8 END))
                                        /
                                        (SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE 1 END)))/7*0.21,0)
                                        +
                       IFNULL(((SUM(CASE WHEN RESPUESTA_9 = '' THEN 0 ELSE RESPUESTA_9 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_10 = '' THEN 0 ELSE RESPUESTA_10 END))
                                        /
                                        (SUM(CASE WHEN RESPUESTA_9 = '' THEN 0 ELSE 1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_10 = '' THEN 0 ELSE 1 END)))/7*0.17,0))
                        /
                        $opc1,2)as VISION
                        FROM BGR.TMP1 g1 WHERE g1.SEGMENTO = g.SEGMENTO
                        AND ResultLevel1 LIKE 'CU1%') AS VISION
                FROM bgr.TMP1 G
                WHERE ResultLevel1 LIKE 'CU1%'
                GROUP BY SEGMENTO
                UNION ALL
                SELECT 
                    'TOTAL ATRIBUTOS',
                    ROUND((SUM(RESPUESTA_1)/SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END))/7*100,2) AS ASESORIA,
                    ROUND((SUM(RESPUESTA_2)/SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END))/7*100,2) AS CLARIDAD,
                    ROUND((SUM(RESPUESTA_3)/SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END))/7*100,2) AS OPORTUNIDAD,
                    ROUND((SUM(RESPUESTA_4)/SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END))/7*100,2) AS ACTITUD,
                    ROUND((SUM(RESPUESTA_5)/SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END))/7*100,2) AS EMPATIA,
                    ROUND((SUM(RESPUESTA_6)/SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END))/7*100,2) AS EFECTIVIDAD,
                    ROUND((SUM(RESPUESTA_7)/SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END))/7*100,2) AS SOLUCION,
                    ROUND((SUM(RESPUESTA_8)/SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE 1 END))/7*100,2) AS PROACTIVIDAD,
                    ROUND((SUM(RESPUESTA_9)/SUM(CASE WHEN RESPUESTA_9 = '' THEN 0 ELSE 1 END))/7*100,2) AS AGILIDAD,
                    ROUND((SUM(RESPUESTA_10)/SUM(CASE WHEN RESPUESTA_10 = '' THEN 0 ELSE 1 END))/7*100,2) AS FLEXIBILIDAD,
                    ROUND((SUM(RESPUESTA_11)/SUM(CASE WHEN RESPUESTA_11 = '' THEN 0 ELSE 1 END))/7*100,2) AS ACCESIBILIDAD,
                    ROUND((SUM(RESPUESTA_12)/SUM(CASE WHEN RESPUESTA_12 = '' THEN 0 ELSE 1 END))/7*100,2) AS INNOVACION,
                    ROUND((
                        IFNULL(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END))
                                        /
                                        (SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)))/7*0.17,0)
                                        +
                        IFNULL(((SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END) 
                                        + 
                                        SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                                        /
                                        (SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)))/7*0.25,0)
                                        +
                        IFNULL(((SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE RESPUESTA_8 END))
                                        /
                                        (SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE 1 END)))/7*0.21,0)
                                        +
                       IFNULL(((SUM(CASE WHEN RESPUESTA_9 = '' THEN 0 ELSE RESPUESTA_9 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_10 = '' THEN 0 ELSE RESPUESTA_10 END))
                                        /
                                        (SUM(CASE WHEN RESPUESTA_9 = '' THEN 0 ELSE 1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_10 = '' THEN 0 ELSE 1 END)))/7*0.17,0))
                        /
                        $opc1,2)as VISION
                FROM bgr.TMP1 G
                WHERE ResultLevel1 LIKE 'CU1%'
                UNION ALL
                        SELECT
                        'TOTAL PILARES',
                        'TOTAL COMUNICACION',
                        ROUND(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END)
                        +
                        SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS TC,
                        'TOTAL PILARES',
                        'TOTAL SERVICIOS',         
                        ROUND(((SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END)
                        +
                        SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                        +
                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS TS,
                        'TOTAL PILARES',
                        'TOTAL PERSONALIZACION',
                        ROUND(((SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)
                        +
                        SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE RESPUESTA_8 END))
                        /
                        (
                        SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE 1 END)
                        ))/7*100,2) AS TP,
                        'TOTAL PROCESOS',
                        ROUND(((SUM(CASE WHEN RESPUESTA_9 = '' THEN 0 ELSE RESPUESTA_9 END)
                        +
                        SUM(CASE WHEN RESPUESTA_10 = '' THEN 0 ELSE RESPUESTA_10 END))
                        /
                        (SUM(CASE WHEN RESPUESTA_9 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_10 = '' THEN 0 ELSE 1 END)))/7*100,2) AS TP,
                        'TOTAL DIGITAL',
						ROUND(((SUM(CASE WHEN RESPUESTA_11 = '' THEN 0 ELSE RESPUESTA_11 END)
                        +
                        SUM(CASE WHEN RESPUESTA_12 = '' THEN 0 ELSE RESPUESTA_12 END))
                        /
                        (SUM(CASE WHEN RESPUESTA_11 = '' THEN 0 ELSE 1 END)
                        +
                        SUM(CASE WHEN RESPUESTA_12 = '' THEN 0 ELSE 1 END)))/7*100,2)AS TD,
                        
                        ROUND((
                        IFNULL(((SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE RESPUESTA_1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE RESPUESTA_2 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE RESPUESTA_3 END))
                                        /
                                        (SUM(CASE WHEN RESPUESTA_1 = '' THEN 0 ELSE 1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_2 = '' THEN 0 ELSE 1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_3 = '' THEN 0 ELSE 1 END)))/7*0.17,0)
                                        +
                        IFNULL(((SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE RESPUESTA_4 END) 
                                        + 
                                        SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE RESPUESTA_5 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE RESPUESTA_6 END))
                                        /
                                        (SUM(CASE WHEN RESPUESTA_4 = '' THEN 0 ELSE 1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_5 = '' THEN 0 ELSE 1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_6 = '' THEN 0 ELSE 1 END)))/7*0.25,0)
                                        +
                        IFNULL(((SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE RESPUESTA_7 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE RESPUESTA_8 END))
                                        /
                                        (SUM(CASE WHEN RESPUESTA_7 = '' THEN 0 ELSE 1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_8 = '' THEN 0 ELSE 1 END)))/7*0.21,0)
                                        +
                       IFNULL(((SUM(CASE WHEN RESPUESTA_9 = '' THEN 0 ELSE RESPUESTA_9 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_10 = '' THEN 0 ELSE RESPUESTA_10 END))
                                        /
                                        (SUM(CASE WHEN RESPUESTA_9 = '' THEN 0 ELSE 1 END)
                                        +
                                        SUM(CASE WHEN RESPUESTA_10 = '' THEN 0 ELSE 1 END)))/7*0.17,0))
                        /
                        $opc1,2)as VISION
                FROM bgr.TMP1 G
                WHERE ResultLevel1 LIKE 'CU1%';";

        return ejecutarConsulta($sql);
        ejecutarConsulta("DROP TABLE BGR.TMP, BGR.TMP1");
    }
}

?>