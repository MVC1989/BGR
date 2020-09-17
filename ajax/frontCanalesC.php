<?php

session_start();

require '../models/frontCanalesM.php';
$frontCanales = new frontCanales();
date_default_timezone_set("America/Lima");
$date = date('Y-m-d H:i:s');
$userId = $_SESSION['usu'];
$rol = $_SESSION['workgroup'];

switch ($_GET["action"]) {
    //*************INFO DE LA CARGA CON LOS FILTROS DE GESTION DE CANALES ELECTRÓNICOS*****************//
    case 'tacometroNPSFiltros':
        $txtCanal = isset($_POST["txtCanal"]) ? LimpiarCadena($_POST["txtCanal"]) : "";
        $txtFechaInicio = isset($_POST["txtFechaInicio"]) ? LimpiarCadena($_POST["txtFechaInicio"]) : "";
        $txtFechaFin = isset($_POST["txtFechaFin"]) ? LimpiarCadena($_POST["txtFechaFin"]) : "";

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
                ROUND((SUM(CASE 
                        WHEN RESPUESTA_15 >= 9 AND RESPUESTA_15 <= 10 THEN 1
                        WHEN RESPUESTA_15 >= 7 AND RESPUESTA_15 <= 8 THEN 0
                WHEN RESPUESTA_15 >= 0 AND RESPUESTA_15 <= 6 THEN -1
                END)/count(RESPUESTA_15))*100,2) AS NPS
                FROM BGR.TMP1 g1; ";
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $NPS = $row["NPS"];
        echo $NPS;
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'tacometroINSFiltros':
        $txtCanal = isset($_POST["txtCanal"]) ? LimpiarCadena($_POST["txtCanal"]) : "";
        $txtFechaInicio = isset($_POST["txtFechaInicio"]) ? LimpiarCadena($_POST["txtFechaInicio"]) : "";
        $txtFechaFin = isset($_POST["txtFechaFin"]) ? LimpiarCadena($_POST["txtFechaFin"]) : "";

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
                ROUND((SUM(CASE 
                        WHEN RESPUESTA_13 >= 8 AND RESPUESTA_13 <= 10 THEN 1
                        WHEN RESPUESTA_13 >= 5 AND RESPUESTA_13 <= 7 THEN 0
                WHEN RESPUESTA_13 >= 1 AND RESPUESTA_13 <= 4 THEN -1
                END)/count(RESPUESTA_13))*100,2) AS INS
                FROM BGR.TMP1 g1; ";
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $INS = $row["INS"];
        echo $INS;
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'tacometroCESFiltros':
        $txtCanal = isset($_POST["txtCanal"]) ? LimpiarCadena($_POST["txtCanal"]) : "";
        $txtFechaInicio = isset($_POST["txtFechaInicio"]) ? LimpiarCadena($_POST["txtFechaInicio"]) : "";
        $txtFechaFin = isset($_POST["txtFechaFin"]) ? LimpiarCadena($_POST["txtFechaFin"]) : "";

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
                        ROUND((SUM(CASE 
                            WHEN RESPUESTA_14 = 'MUY FACIL' THEN 0
                            WHEN RESPUESTA_14 = 'POCO FACIL' THEN 1
                            WHEN RESPUESTA_14 = 'FACIL' THEN 0
                            WHEN RESPUESTA_14 = 'DIFICIL' THEN 1
                            WHEN RESPUESTA_14 = 'MUY DIFICIL' THEN 1
                        END)/count(RESPUESTA_14))*100,2) AS CES
                    FROM BGR.TMP1 g1; ";
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $CES = $row["CES"];
        echo $CES;
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'tacometroVisionFiltros':
        $txtCanal = isset($_POST["txtCanal"]) ? LimpiarCadena($_POST["txtCanal"]) : "";
        $txtFechaInicio = isset($_POST["txtFechaInicio"]) ? LimpiarCadena($_POST["txtFechaInicio"]) : "";
        $txtFechaFin = isset($_POST["txtFechaFin"]) ? LimpiarCadena($_POST["txtFechaFin"]) : "";

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
        if($txtCanal == 'BGR MOVIL' || $txtCanal == 'BGR NET'){
            $opc1 = '0.55*100';
        }
        else{
            $opc1 = '0.8*100';
        }
        $sql = "SELECT 
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
            FROM bgr.tmp1 G
            WHERE RESULTLEVEL1 LIKE 'CU1%'; ";

        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $VISION = $row["VISION"];
        echo $VISION;
        ejecutarConsulta("DROP TABLE BGR.TMP,BGR.TMP1;");
        break;

    case 'selectAllLealtadFiltros':
        $txtCanal = isset($_POST["txtCanal"]) ? LimpiarCadena($_POST["txtCanal"]) : "";
        $txtFechaInicio = isset($_POST["txtFechaInicio"]) ? LimpiarCadena($_POST["txtFechaInicio"]) : "";
        $txtFechaFin = isset($_POST["txtFechaFin"]) ? LimpiarCadena($_POST["txtFechaFin"]) : "";

        $respuesta = $frontCanales->selectAllLealtadFiltros($txtCanal, $txtFechaInicio, $txtFechaFin); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        $INS = Array();
        $CES = Array();
        $NPS = Array();
        $LEALTAD = Array();
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            //SEMAFORIZACION INS
            if ($registrar->INS >= 80.00 && $registrar->INS <= 100) {
                $INS = array(
                    "0" => $registrar->INS . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->INS >= 60.00 && $registrar->INS <= 79.99) {
                $INS = array(
                    "0" => $registrar->INS . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->INS <= 59.99) {
                $INS = array(
                    "0" => $registrar->INS . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            }
            //SEMAFORIZACION CES
            if ($registrar->CES >= 0.00 && $registrar->CES <= 14.99) {
                $CES = array(
                    "0" => $registrar->CES . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->CES >= 15.00 && $registrar->CES <= 29.99) {
                $CES = array(
                    "0" => $registrar->CES . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->CES >= 30.00 && $registrar->CES <= 100) {
                $CES = array(
                    "0" => $registrar->CES . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            }
            //SEMAFORIZACION NPS
            if ($registrar->NPS >= 85.00 && $registrar->NPS <= 100) {
                $NPS = array(
                    "0" => $registrar->NPS . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->NPS >= 60.00 && $registrar->NPS <= 84.99) {
                $NPS = array(
                    "0" => $registrar->NPS . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->NPS <= 59.99) {
                $NPS = array(
                    "0" => $registrar->NPS . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            }
            //SEMAFORIZACION LEALTAD
            if ($registrar->LEALTAD >= 80.00 && $registrar->LEALTAD <= 100) {
                $LEALTAD = array(
                    "0" => $registrar->LEALTAD . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->LEALTAD >= 60.00 && $registrar->LEALTAD <= 79.99) {
                $LEALTAD = array(
                    "0" => $registrar->LEALTAD . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->LEALTAD <= 59.99) {
                $LEALTAD = array(
                    "0" => $registrar->LEALTAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            }
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->SEGMENTO, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->MUESTRA,
                "2" => ($registrar->NPS == '' || $registrar->NPS == '-') ? '-' : $NPS,
                "3" => ($registrar->INS == '' || $registrar->INS == '-') ? '-' : $INS,
                "4" => ($registrar->CES == '' || $registrar->CES == '-') ? '-' : $CES,
                "5" => ($registrar->LEALTAD == '' || $registrar->LEALTAD == '-') ? '-' : $LEALTAD,
            );
        }
        $resultados = array(
            "sEcho" => 1, /* informacion para la herramienta datatables */
            "iTotalRecords" => count($datos), /* envía el total de columnas a visualizar */
            "iTotalDisplayRecords" => count($datos), /* envia el total de filas a visualizar */
            "aaData" => $datos /* envía el arreglo completo que se llenó con el while */
        );
        echo json_encode($resultados);
        break;

    case 'selectAllPilaresFiltros':
        $txtCanal = isset($_POST["txtCanal"]) ? LimpiarCadena($_POST["txtCanal"]) : "";
        $txtFechaInicio = isset($_POST["txtFechaInicio"]) ? LimpiarCadena($_POST["txtFechaInicio"]) : "";
        $txtFechaFin = isset($_POST["txtFechaFin"]) ? LimpiarCadena($_POST["txtFechaFin"]) : "";

        $respuesta = $frontCanales->selectAllPilaresFiltros($txtCanal, $txtFechaInicio, $txtFechaFin); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $ASESORIA = Array();
            $CLARIDAD = Array();
            $OPORTUNIDAD = Array();
            $ACTITUD = Array();
            $EMPATIA = Array();
            $EFECTIVIDAD = Array();
            $SOLUCION = Array();
            $PROACTIVIDAD = Array();
            $AGILIDAD = Array();
            $FLEXIBILIDAD = Array();
            $ACCESIBILIDAD = Array();
            $INNOVACION = Array();
            $VISION = Array();
            //SEMAFORIZACION ASESORIA
            if ($registrar->ASESORIA >= 80.00 && $registrar->ASESORIA <= 100) {
                $ASESORIA = array(
                    "0" => $registrar->ASESORIA . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->ASESORIA >= 60.00 && $registrar->ASESORIA <= 79.99) {
                $ASESORIA = array(
                    "0" => $registrar->ASESORIA . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->ASESORIA <= 0.00 && $registrar->ASESORIA <= 59.99) {
                $ASESORIA = array(
                    "0" => $registrar->ASESORIA . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            } else {
                $ASESORIA = array(
                    "0" => '-',
                );
            }
            //SEMAFORIZACION CLARIDAD
            if ($registrar->CLARIDAD >= 80.00 && $registrar->CLARIDAD <= 100) {
                $CLARIDAD = array(
                    "0" => $registrar->CLARIDAD . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->CLARIDAD >= 60.00 && $registrar->CLARIDAD <= 79.99) {
                $CLARIDAD = array(
                    "0" => $registrar->CLARIDAD . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->CLARIDAD >= 0.00 && $registrar->CLARIDAD <= 59.99) {
                $CLARIDAD = array(
                    "0" => $registrar->CLARIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            } else {
                $CLARIDAD = array(
                    "0" => '-',
                );
            }
            //SEMAFORIZACION OPORTUNIDAD
            if ($registrar->OPORTUNIDAD >= 80.00 && $registrar->OPORTUNIDAD <= 100) {
                $OPORTUNIDAD = array(
                    "0" => $registrar->OPORTUNIDAD . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->OPORTUNIDAD >= 60.00 && $registrar->OPORTUNIDAD <= 79.99) {
                $OPORTUNIDAD = array(
                    "0" => $registrar->OPORTUNIDAD . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->OPORTUNIDAD >= 0.00 && $registrar->OPORTUNIDAD <= 59.99) {
                $OPORTUNIDAD = array(
                    "0" => $registrar->OPORTUNIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            } else {
                $OPORTUNIDAD = array(
                    "0" => '-',
                );
            }
            //SEMAFORIZACION ACTITUD
            if ($registrar->ACTITUD >= 80.00 && $registrar->ACTITUD <= 100) {
                $ACTITUD = array(
                    "0" => $registrar->ACTITUD . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->ACTITUD >= 60.00 && $registrar->ACTITUD <= 79.99) {
                $ACTITUD = array(
                    "0" => $registrar->ACTITUD . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->ACTITUD >= 0.00 && $registrar->ACTITUD <= 59.99) {
                $ACTITUD = array(
                    "0" => $registrar->ACTITUD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            } else {
                $ACTITUD = array(
                    "0" => '-',
                );
            }
            //SEMAFORIZACION EMPATIA
            if ($registrar->EMPATIA >= 80.00 && $registrar->EMPATIA <= 100) {
                $EMPATIA = array(
                    "0" => $registrar->EMPATIA . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->EMPATIA >= 60.00 && $registrar->EMPATIA <= 79.99) {
                $EMPATIA = array(
                    "0" => $registrar->EMPATIA . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->EMPATIA >= 0.00 && $registrar->EMPATIA <= 59.99) {
                $EMPATIA = array(
                    "0" => $registrar->EMPATIA . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            } else {
                $EMPATIA = array(
                    "0" => '-',
                );
            }
            //SEMAFORIZACION EFECTIVIDAD
            if ($registrar->EFECTIVIDAD >= 80.00 && $registrar->EFECTIVIDAD <= 100) {
                $EFECTIVIDAD = array(
                    "0" => $registrar->EFECTIVIDAD . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->EFECTIVIDAD >= 60.00 && $registrar->EFECTIVIDAD <= 79.99) {
                $EFECTIVIDAD = array(
                    "0" => $registrar->EFECTIVIDAD . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->EFECTIVIDAD >= 0.00 && $registrar->EFECTIVIDAD <= 59.99) {
                $EFECTIVIDAD = array(
                    "0" => $registrar->EFECTIVIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            } else {
                $EFECTIVIDAD = array(
                    "0" => '-',
                );
            }
            //SEMAFORIZACION SOLUCION
            if ($registrar->SOLUCION >= 80.00 && $registrar->SOLUCION <= 100) {
                $SOLUCION = array(
                    "0" => $registrar->SOLUCION . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->SOLUCION >= 60.00 && $registrar->SOLUCION <= 79.99) {
                $SOLUCION = array(
                    "0" => $registrar->SOLUCION . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->SOLUCION >= 0.00 && $registrar->SOLUCION <= 59.99) {
                $SOLUCION = array(
                    "0" => $registrar->SOLUCION . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            } else {
                $SOLUCION = array(
                    "0" => '-',
                );
            }
            //SEMAFORIZACION PROACTIVIDAD
            if ($registrar->PROACTIVIDAD >= 80.00 && $registrar->PROACTIVIDAD <= 100) {
                $PROACTIVIDAD = array(
                    "0" => $registrar->PROACTIVIDAD . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->PROACTIVIDAD >= 60.00 && $registrar->PROACTIVIDAD <= 79.99) {
                $PROACTIVIDAD = array(
                    "0" => $registrar->PROACTIVIDAD . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->PROACTIVIDAD >= 0.00 && $registrar->PROACTIVIDAD <= 59.99) {
                $PROACTIVIDAD = array(
                    "0" => $registrar->PROACTIVIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            } else {
                $PROACTIVIDAD = array(
                    "0" => '-',
                );
            }
            //SEMAFORIZACION AGILIDAD
            if ($registrar->AGILIDAD >= 80.00 && $registrar->AGILIDAD <= 100) {
                $AGILIDAD = array(
                    "0" => $registrar->AGILIDAD . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->AGILIDAD >= 60.00 && $registrar->AGILIDAD <= 79.99) {
                $AGILIDAD = array(
                    "0" => $registrar->AGILIDAD . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->AGILIDAD >= 0.00 && $registrar->AGILIDAD <= 59.99) {
                $AGILIDAD = array(
                    "0" => $registrar->AGILIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            } else {
                $AGILIDAD = array(
                    "0" => '-',
                );
            }
            //SEMAFORIZACION FLEXIBILIDAD
            if ($registrar->FLEXIBILIDAD >= 80.00 && $registrar->FLEXIBILIDAD <= 100) {
                $FLEXIBILIDAD = array(
                    "0" => $registrar->FLEXIBILIDAD . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->FLEXIBILIDAD >= 60.00 && $registrar->FLEXIBILIDAD <= 79.99) {
                $FLEXIBILIDAD = array(
                    "0" => $registrar->FLEXIBILIDAD . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->FLEXIBILIDAD >= 0.00 && $registrar->FLEXIBILIDAD <= 59.99) {
                $FLEXIBILIDAD = array(
                    "0" => $registrar->FLEXIBILIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            } else {
                $FLEXIBILIDAD = array(
                    "0" => '-',
                );
            }
            //SEMAFORIZACION ACCESIBILIDAD
            if ($registrar->ACCESIBILIDAD >= 80.00 && $registrar->ACCESIBILIDAD <= 100) {
                $ACCESIBILIDAD = array(
                    "0" => $registrar->ACCESIBILIDAD . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->ACCESIBILIDAD >= 60.00 && $registrar->ACCESIBILIDAD <= 79.99) {
                $ACCESIBILIDAD = array(
                    "0" => $registrar->ACCESIBILIDAD . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->ACCESIBILIDAD >= 0.00 && $registrar->ACCESIBILIDAD <= 59.99) {
                $ACCESIBILIDAD = array(
                    "0" => $registrar->ACCESIBILIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            } else {
                $ACCESIBILIDAD = array(
                    "0" => '-',
                );
            }
            //SEMAFORIZACION INNOVACION
            if ($registrar->INNOVACION >= 80.00 && $registrar->INNOVACION <= 100) {
                $INNOVACION = array(
                    "0" => $registrar->INNOVACION . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->INNOVACION >= 60.00 && $registrar->INNOVACION <= 79.99) {
                $INNOVACION = array(
                    "0" => $registrar->INNOVACION . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->INNOVACION >= 0.00 && $registrar->INNOVACION <= 59.99) {
                $INNOVACION = array(
                    "0" => $registrar->INNOVACION . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            } else {
                $INNOVACION = array(
                    "0" => '-',
                );
            }
            //SEMAFORIZACION VISION
            if ($registrar->VISION >= 80.00 && $registrar->VISION <= 100) {
                $VISION = array(
                    "0" => $registrar->VISION . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->VISION >= 60.00 && $registrar->VISION <= 79.99) {
                $VISION = array(
                    "0" => $registrar->VISION . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->VISION >= 0.00 && $registrar->VISION <= 59.99) {
                $VISION = array(
                    "0" => $registrar->VISION . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            } else {
                $VISION = array(
                    "0" => '-',
                );
            }
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->SEGMENTO, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => ($registrar->ASESORIA == '' || $registrar->ASESORIA == '-') ? '-' : $ASESORIA,
                "2" => ($registrar->CLARIDAD == '' || $registrar->CLARIDAD == '-') ? '-' : $CLARIDAD,
                "3" => ($registrar->OPORTUNIDAD == '' || $registrar->OPORTUNIDAD == '-') ? '-' : $OPORTUNIDAD,
                "4" => ($registrar->ACTITUD == '' || $registrar->ACTITUD == '-') ? '-' : $ACTITUD,
                "5" => ($registrar->EMPATIA == '' || $registrar->EMPATIA == '-') ? '-' : $EMPATIA,
                "6" => ($registrar->EFECTIVIDAD == '' || $registrar->EFECTIVIDAD == '-') ? '-' : $EFECTIVIDAD,
                "7" => ($registrar->SOLUCION == '' || $registrar->SOLUCION == '-') ? '-' : $SOLUCION,
                "8" => ($registrar->PROACTIVIDAD == '' || $registrar->PROACTIVIDAD == '-') ? '-' : $PROACTIVIDAD,
                "9" => ($registrar->AGILIDAD == '' || $registrar->AGILIDAD == '-') ? '-' : $AGILIDAD,
                "10" => ($registrar->FLEXIBILIDAD == '' || $registrar->FLEXIBILIDAD == '-') ? '-' : $FLEXIBILIDAD,
                "11" => ($registrar->ACCESIBILIDAD == '' || $registrar->ACCESIBILIDAD == '-') ? '-' : $ACCESIBILIDAD,
                "12" => ($registrar->INNOVACION == '' || $registrar->INNOVACION == '-') ? '-' : $INNOVACION,
                "13" => ($registrar->VISION == '' || $registrar->VISION == '-') ? '-' : $VISION,
            );
        }

        $resultados = array(
            "sEcho" => 1, /* informacion para la herramienta datatables */
            "iTotalRecords" => count($datos), /* envía el total de columnas a visualizar */
            "iTotalDisplayRecords" => count($datos), /* envia el total de filas a visualizar */
            "aaData" => $datos /* envía el arreglo completo que se llenó con el while */
        );
        echo json_encode($resultados);
        break;
}
?>