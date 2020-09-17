<?php

session_start();

require '../models/frontPrincipalM.php';
$frontPrincipal = new frontPrincipal();
date_default_timezone_set("America/Lima");
$date = date('Y-m-d H:i:s');
$userId = $_SESSION['usu'];
$region = $_SESSION['Region'];
$agencias = $_SESSION['Agencias'];
$rol = $_SESSION['workgroup'];

switch ($_GET["action"]) {
    //***************************FILTROS PARA INICAR LAS BÚSQUEDAS
    case 'region':
        if ($rol == "1") {
            $result = ejecutarConsulta("SELECT distinct(Region) 'Region' FROM agencias");
            echo '<option value="">TODAS</option>';
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                echo '<option value="' . $row["Region"] . '">' . $row["Region"] . '</option>';
            }
        } else if ($rol == "2") {
            $result = ejecutarConsulta("SELECT distinct(Region) 'Region' FROM agencias where region like '%$region%'");
            if ($region == '') {
                echo '<option value="">Todas</option>';
            }
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                echo '<option value="' . $row["Region"] . '">' . $row["Region"] . '</option>';
            }
        } else if ($rol == "3") {
            $valor_array = explode(',', $agencias); //explode convierte string a array e implode convierte array a string
            $longitud = count($valor_array);
            for ($i = 0; $i < $longitud; $i++) {
                $vAgencia = trim($valor_array[$i]);
                if ($i == 0) {
                    ejecutarConsulta("CREATE TEMPORARY TABLE bgr.temp AS (SELECT REGION FROM bgr.agencias "
                            . "WHERE NOMBRE_AGENCIA = '$vAgencia');");
                } else {
                    ejecutarConsulta("INSERT BGR.TEMP SELECT REGION FROM bgr.agencias
                WHERE NOMBRE_AGENCIA = '$vAgencia'");
                }
            }
            $result = ejecutarConsulta("SELECT DISTINCT Region FROM BGR.TEMP");
            $numRowC = $result->num_rows;
            if ($numRowC == 1) {
                echo '<option value="">Todas</option>';
            }
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                echo '<option value="' . $row["Region"] . '">' . $row["Region"] . '</option>';
            }
            ejecutarConsulta("DROP TABLE BGR.TEMP");
        }
        break;

    case 'agencias':
        $txtRegion = isset($_POST["txtRegion"]) ? LimpiarCadena($_POST["txtRegion"]) : "";
        if ($rol == "1") {
            $result = ejecutarConsulta("SELECT distinct(NOMBRE_AGENCIA) 'NOMBRE_AGENCIA' FROM agencias where region like '%$txtRegion%' ORDER BY NOMBRE_AGENCIA ");
            echo '<option value="">Todas</option>';
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                echo '<option value="' . $row["NOMBRE_AGENCIA"] . '">' . $row["NOMBRE_AGENCIA"] . '</option>';
            }
        } else if ($rol == "2") {
            $result = ejecutarConsulta("SELECT distinct(NOMBRE_AGENCIA) 'NOMBRE_AGENCIA' FROM agencias where region like '%$region%' ORDER BY NOMBRE_AGENCIA ");
            echo '<option value="">Todas</option>';
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                echo '<option value="' . $row["NOMBRE_AGENCIA"] . '">' . $row["NOMBRE_AGENCIA"] . '</option>';
            }
        } else if ($rol == "3") {
            $valor_array = explode(',', $agencias); //explode convierte string a array e implode convierte array a string
            $longitud = count($valor_array);
            echo '<option value="">Todas</option>';
            for ($i = 0; $i < $longitud; $i++) {
                $vAgencia = trim($valor_array[$i]);
                $result = ejecutarConsulta("SELECT distinct(NOMBRE_AGENCIA) 'NOMBRE_AGENCIA' FROM agencias "
                        . "where region like '%$Region%' and NOMBRE_AGENCIA = '$vAgencia' ORDER BY NOMBRE_AGENCIA ");
                while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                    echo '<option value="' . $row["NOMBRE_AGENCIA"] . '">' . $row["NOMBRE_AGENCIA"] . '</option>';
                }
            }
        }
        break;

    case 'agenciasList':
        $txtRegion = isset($_POST["txtRegion"]) ? LimpiarCadena($_POST["txtRegion"]) : "";
        if ($rol == "1") {
            $result = ejecutarConsulta("SELECT distinct(NOMBRE_AGENCIA) 'NOMBRE_AGENCIA' FROM agencias where region like '%$txtRegion%' ORDER BY NOMBRE_AGENCIA ");
            echo '<option value="">Todas</option>';
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                echo '<option value="' . $row["NOMBRE_AGENCIA"] . '">' . $row["NOMBRE_AGENCIA"] . '</option>';
            }
        } else if ($rol == "2") {
            $result = ejecutarConsulta("SELECT distinct(NOMBRE_AGENCIA) 'NOMBRE_AGENCIA' FROM agencias where region like '%$txtRegion%' ORDER BY NOMBRE_AGENCIA ");
            echo '<option value="">Todas</option>';
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                echo '<option value="' . $row["NOMBRE_AGENCIA"] . '">' . $row["NOMBRE_AGENCIA"] . '</option>';
            }
        } else if ($rol == "3") {
            $valor_array = explode(',', $agencias); //explode convierte string a array e implode convierte array a string
            $longitud = count($valor_array);
            echo '<option value="">Todas</option>';
            for ($i = 0; $i < $longitud; $i++) {
                $vAgencia = trim($valor_array[$i]);
                $result = ejecutarConsulta("SELECT distinct(NOMBRE_AGENCIA) 'NOMBRE_AGENCIA' FROM agencias "
                        . "where region like '%$txtRegion%' and NOMBRE_AGENCIA = '$vAgencia' ORDER BY NOMBRE_AGENCIA ");
                while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                    echo '<option value="' . $row["NOMBRE_AGENCIA"] . '">' . $row["NOMBRE_AGENCIA"] . '</option>';
                }
            }
        }
        break;

    //*************INFO DE LA CARGA INICIAL GESTION DE OFICINAS
    case 'tacometroNPS':
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
                ROUND((SUM(CASE 
                            WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                            WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                    WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                END)/count(RESPUESTA_11))*100,2) AS NPS
                FROM BGR.TMP g1 WHERE ResultLevel1 LIKE 'CU1%';";
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $NPS = $row["NPS"];
        echo $NPS;
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'progressNPS':
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
            } else {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            }
        }
        $sql = ejecutarConsulta("select
                    ROUND((SUM(CASE WHEN RESPUESTA_11 >=0 AND RESPUESTA_11 <= 6 THEN 1 ELSE 0 END )/COUNT(RESPUESTA_11))*100,2) AS DETRACTORES,
                    ROUND((SUM(CASE WHEN RESPUESTA_11 >=7 AND RESPUESTA_11 <=8 THEN 1 ELSE 0 END )/COUNT(RESPUESTA_11))*100,2) AS NEUTROS,
                    ROUND((SUM(CASE WHEN RESPUESTA_11 >=9 AND RESPUESTA_11 <=10 THEN 1 ELSE 0 END )/COUNT(RESPUESTA_11))*100,2) AS PROMOTORES
                from bgr.gestionfinal
                where importid = 'BGR_ENERO_9937REG'
                AND ResultLevel1 LIKE 'CU1%';");


        while ($registrar = $sql->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->DETRACTORES, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->NEUTROS,
                "2" => $registrar->PROMOTORES,
            );
        }
        $resultados = array(
            "sEcho" => 1, /* informacion para la herramienta datatables */
            "iTotalRecords" => count($datos), /* envía el total de columnas a visualizar */
            "iTotalDisplayRecords" => count($datos), /* envia el total de filas a visualizar */
            "aaData" => $datos /* envía el arreglo completo que se llenó con el while */
        );
        echo json_encode($resultados);
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'tacometroINS':
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
            } else {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            }
        }
        $sql = "SELECT 
                    ROUND((SUM(CASE 
                            WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                            WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                            WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                END)/count(RESPUESTA_9))*100,2) AS INS
                FROM BGR.TMP g1 
                WHERE ResultLevel1 LIKE 'CU1%'";
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $INS = $row["INS"];
        echo $INS;
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'tacometroCES':
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
            } else {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            }
        }
        $sql = "SELECT 
                ROUND((SUM(CASE 
                            WHEN RESPUESTA_10 = 'MUY FACIL' THEN 0
                            WHEN RESPUESTA_10 = 'POCO FACIL' THEN 1
                            WHEN RESPUESTA_10 = 'FACIL' THEN 0
                            WHEN RESPUESTA_10 = 'DIFICIL' THEN 1
                            WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 1
                END)/count(RESPUESTA_10))*100,2) AS CES
                FROM BGR.TMP g1 WHERE ResultLevel1 LIKE 'CU1%'";
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $CES = $row["CES"];
        echo $CES;
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'tacometroVision':
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
            } else {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            }
        }
        $sql = "SELECT 
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
            FROM bgr.tmp G
            WHERE ResultLevel1 LIKE 'CU1%';";
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $VISION = $row["VISION"];
        echo $VISION;
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'tacometroVisionNegocios':
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
            FROM bgr.tmp G
            WHERE ResultLevel1 LIKE 'CU1%';";
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $VISION = $row["VISION"];
        echo $VISION;
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'tacometroVisionServicios':
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
            FROM bgr.tmp G
            WHERE ResultLevel1 LIKE 'CU1%';";
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $VISION = $row["VISION"];
        echo $VISION;
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'selectAllLealtad':
        $respuesta = $frontPrincipal->selectAllLealtad($agencias); /* llama a la función del modelo */
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
                "0" => $registrar->SECCION, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
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

    case 'selectAllPilares':
        $respuesta = $frontPrincipal->selectAllPilares($agencias); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $ASESORIA = Array();
            $CLARIDAD = Array();
            $AMABILIDAD = Array();
            $EMPATIA = Array();
            $EFECTIVIDAD = Array();
            $PERSONALIDAD = Array();
            $AGILIDAD = Array();
            $ACCESIBILIDAD = Array();
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
            } else if ($registrar->ASESORIA <= 59.99) {
                $ASESORIA = array(
                    "0" => $registrar->ASESORIA . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->CLARIDAD <= 59.99) {
                $CLARIDAD = array(
                    "0" => $registrar->CLARIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            }
            //SEMAFORIZACION AMABILIDAD
            if ($registrar->AMABILIDAD >= 80.00 && $registrar->AMABILIDAD <= 100) {
                $AMABILIDAD = array(
                    "0" => $registrar->AMABILIDAD . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->AMABILIDAD >= 60.00 && $registrar->AMABILIDAD <= 79.99) {
                $AMABILIDAD = array(
                    "0" => $registrar->AMABILIDAD . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->AMABILIDAD <= 59.99) {
                $AMABILIDAD = array(
                    "0" => $registrar->AMABILIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->EMPATIA <= 59.99) {
                $EMPATIA = array(
                    "0" => $registrar->EMPATIA . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->EFECTIVIDAD <= 59.99) {
                $EFECTIVIDAD = array(
                    "0" => $registrar->EFECTIVIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            }
            //SEMAFORIZACION PERSONALIZACION
            if ($registrar->PERSONALIZACION >= 80.00 && $registrar->PERSONALIZACION <= 100) {
                $PERSONALIZACION = array(
                    "0" => $registrar->PERSONALIZACION . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->PERSONALIZACION >= 60.00 && $registrar->PERSONALIZACION <= 79.99) {
                $PERSONALIZACION = array(
                    "0" => $registrar->PERSONALIZACION . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->PERSONALIZACION <= 59.99) {
                $PERSONALIZACION = array(
                    "0" => $registrar->PERSONALIZACION . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->AGILIDAD <= 59.99) {
                $AGILIDAD = array(
                    "0" => $registrar->AGILIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->ACCESIBILIDAD <= 59.99) {
                $ACCESIBILIDAD = array(
                    "0" => $registrar->ACCESIBILIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->VISION <= 59.99) {
                $VISION = array(
                    "0" => $registrar->VISION . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            }
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->SECCION, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => ($registrar->ASESORIA == '' || $registrar->ASESORIA == '-') ? '-' : $ASESORIA,
                "2" => ($registrar->CLARIDAD == '' || $registrar->CLARIDAD == '-') ? '-' : $CLARIDAD,
                "3" => ($registrar->AMABILIDAD == '' || $registrar->AMABILIDAD == '-') ? '-' : $AMABILIDAD,
                "4" => ($registrar->EMPATIA == '' || $registrar->EMPATIA == '-') ? '-' : $EMPATIA,
                "5" => ($registrar->EFECTIVIDAD == '' || $registrar->EFECTIVIDAD == '-') ? '-' : $EFECTIVIDAD,
                "6" => ($registrar->PERSONALIZACION == '' || $registrar->PERSONALIZACION == '-') ? '-' : $PERSONALIZACION,
                "7" => ($registrar->AGILIDAD == '' || $registrar->AGILIDAD == '-') ? '-' : $AGILIDAD,
                "8" => ($registrar->ACCESIBILIDAD == '' || $registrar->ACCESIBILIDAD == '-') ? '-' : $ACCESIBILIDAD,
                "9" => ($registrar->VISION == '' || $registrar->VISION == '-') ? '-' : $VISION,
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

    //*************INFO DE LA CARGA CON LOS FILTROS DE GESTION DE OFICINAS
    case 'tacometroNPSFiltros':
        $txtRegion = isset($_POST["txtRegion"]) ? LimpiarCadena($_POST["txtRegion"]) : "";
        $txtAgencia = isset($_POST["txtAgencia"]) ? LimpiarCadena($_POST["txtAgencia"]) : "";
        $txtTipoCliente = isset($_POST["txtTipoCliente"]) ? LimpiarCadena($_POST["txtTipoCliente"]) : "";
        $txtFechaInicio = isset($_POST["txtFechaInicio"]) ? LimpiarCadena($_POST["txtFechaInicio"]) : "";
        $txtFechaFin = isset($_POST["txtFechaFin"]) ? LimpiarCadena($_POST["txtFechaFin"]) : "";
        $txtArea = isset($_POST["txtArea"]) ? LimpiarCadena($_POST["txtArea"]) : "";
        $txtSeccion = isset($_POST["txtSeccion"]) ? LimpiarCadena($_POST["txtSeccion"]) : "";

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
                ROUND((SUM(CASE 
                        WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                        WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                END)/count(RESPUESTA_11))*100,2) AS NPS
                FROM BGR.TMP1 g1; ";
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $NPS = $row["NPS"];
        echo $NPS;
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'progressNPSFiltros':
        $valor_array = explode(',', $agencias); //explode convierte string a array e implode convierte array a string
        $longitud = count($valor_array);
        for ($i = 0; $i < $longitud; $i++) {
            $vAgencia = trim($valor_array[$i]);
            if ($i == 0) {
                ejecutarConsulta("CREATE TEMPORARY TABLE bgr.tmp AS ("
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            } else {
                ejecutarConsulta("INSERT INTO BGR.TMP( "
                        . "SELECT * FROM bgr.GESTIONFINAL "
                        . "WHERE AGENCIA LIKE '%$vAgencia%'"
                        . "AND RESULTLEVEL1 LIKE 'CU1%');");
            }
        }
        $sql = ejecutarConsulta("select
                    ROUND((SUM(CASE WHEN RESPUESTA_11 >=0 AND RESPUESTA_11 <= 6 THEN 1 ELSE 0 END )/COUNT(RESPUESTA_11))*100,2) AS DETRACTORES,
                    ROUND((SUM(CASE WHEN RESPUESTA_11 >=7 AND RESPUESTA_11 <=8 THEN 1 ELSE 0 END )/COUNT(RESPUESTA_11))*100,2) AS NEUTROS,
                    ROUND((SUM(CASE WHEN RESPUESTA_11 >=9 AND RESPUESTA_11 <=10 THEN 1 ELSE 0 END )/COUNT(RESPUESTA_11))*100,2) AS PROMOTORES
                from bgr.gestionfinal
                where importid = 'BGR_ENERO_9937REG'
                AND ResultLevel1 LIKE 'CU1%';");


        while ($registrar = $sql->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->DETRACTORES, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->NEUTROS,
                "2" => $registrar->PROMOTORES,
            );
        }
        $resultados = array(
            "sEcho" => 1, /* informacion para la herramienta datatables */
            "iTotalRecords" => count($datos), /* envía el total de columnas a visualizar */
            "iTotalDisplayRecords" => count($datos), /* envia el total de filas a visualizar */
            "aaData" => $datos /* envía el arreglo completo que se llenó con el while */
        );
        echo json_encode($resultados);
        ejecutarConsulta("DROP TABLE BGR.TMP, BGR.TMP1");
        break;

    case 'tacometroINSFiltros':
        $txtRegion = isset($_POST["txtRegion"]) ? LimpiarCadena($_POST["txtRegion"]) : "";
        $txtAgencia = isset($_POST["txtAgencia"]) ? LimpiarCadena($_POST["txtAgencia"]) : "";
        $txtTipoCliente = isset($_POST["txtTipoCliente"]) ? LimpiarCadena($_POST["txtTipoCliente"]) : "";
        $txtFechaInicio = isset($_POST["txtFechaInicio"]) ? LimpiarCadena($_POST["txtFechaInicio"]) : "";
        $txtFechaFin = isset($_POST["txtFechaFin"]) ? LimpiarCadena($_POST["txtFechaFin"]) : "";
        $txtArea = isset($_POST["txtArea"]) ? LimpiarCadena($_POST["txtArea"]) : "";
        $txtSeccion = isset($_POST["txtSeccion"]) ? LimpiarCadena($_POST["txtSeccion"]) : "";

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
                ROUND((SUM(CASE 
                        WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                        WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                END)/count(RESPUESTA_9))*100,2) AS INS
                FROM BGR.TMP1 g1; ";
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $INS = $row["INS"];
        echo $INS;
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'tacometroCESFiltros':
        $txtRegion = isset($_POST["txtRegion"]) ? LimpiarCadena($_POST["txtRegion"]) : "";
        $txtAgencia = isset($_POST["txtAgencia"]) ? LimpiarCadena($_POST["txtAgencia"]) : "";
        $txtTipoCliente = isset($_POST["txtTipoCliente"]) ? LimpiarCadena($_POST["txtTipoCliente"]) : "";
        $txtFechaInicio = isset($_POST["txtFechaInicio"]) ? LimpiarCadena($_POST["txtFechaInicio"]) : "";
        $txtFechaFin = isset($_POST["txtFechaFin"]) ? LimpiarCadena($_POST["txtFechaFin"]) : "";
        $txtArea = isset($_POST["txtArea"]) ? LimpiarCadena($_POST["txtArea"]) : "";
        $txtSeccion = isset($_POST["txtSeccion"]) ? LimpiarCadena($_POST["txtSeccion"]) : "";

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
                        ROUND((SUM(CASE 
                            WHEN RESPUESTA_10 = 'MUY FACIL' THEN 0
                            WHEN RESPUESTA_10 = 'POCO FACIL' THEN 1
                            WHEN RESPUESTA_10 = 'FACIL' THEN 0
                            WHEN RESPUESTA_10 = 'DIFICIL' THEN 1
                            WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 1
                        END)/count(RESPUESTA_10))*100,2) AS CES
                    FROM BGR.TMP1 g1; ";
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $CES = $row["CES"];
        echo $CES;
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'tacometroVisionFiltros':
        $txtRegion = isset($_POST["txtRegion"]) ? LimpiarCadena($_POST["txtRegion"]) : "";
        $txtAgencia = isset($_POST["txtAgencia"]) ? LimpiarCadena($_POST["txtAgencia"]) : "";
        $txtTipoCliente = isset($_POST["txtTipoCliente"]) ? LimpiarCadena($_POST["txtTipoCliente"]) : "";
        $txtFechaInicio = isset($_POST["txtFechaInicio"]) ? LimpiarCadena($_POST["txtFechaInicio"]) : "";
        $txtFechaFin = isset($_POST["txtFechaFin"]) ? LimpiarCadena($_POST["txtFechaFin"]) : "";
        $txtArea = isset($_POST["txtArea"]) ? LimpiarCadena($_POST["txtArea"]) : "";
        $txtSeccion = isset($_POST["txtSeccion"]) ? LimpiarCadena($_POST["txtSeccion"]) : "";

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
        if ($txtSeccion == 'Cajas' || $txtSeccion == 'CAJAS') {
            $sql = "SELECT 
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
                        CASE WHEN SECCION = 'CAJAS' THEN 0.42 ELSE 0.8 END *100,2)as VISION
            FROM bgr.tmp1 G
            WHERE RESULTLEVEL1 LIKE 'CU1%'; ";
        } else {
            $sql = "SELECT 
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
            FROM bgr.tmp1 G
            WHERE RESULTLEVEL1 LIKE 'CU1%'; ";
        }
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $VISION = $row["VISION"];
        echo $VISION;
        ejecutarConsulta("DROP TABLE BGR.TMP,BGR.TMP1;");
        break;

    case 'selectAllLealtadFiltros':
        $txtRegion = isset($_POST["txtRegion"]) ? LimpiarCadena($_POST["txtRegion"]) : "";
        $txtAgencia = isset($_POST["txtAgencia"]) ? LimpiarCadena($_POST["txtAgencia"]) : "";
        $txtTipoCliente = isset($_POST["txtTipoCliente"]) ? LimpiarCadena($_POST["txtTipoCliente"]) : "";
        $txtFechaInicio = isset($_POST["txtFechaInicio"]) ? LimpiarCadena($_POST["txtFechaInicio"]) : "";
        $txtFechaFin = isset($_POST["txtFechaFin"]) ? LimpiarCadena($_POST["txtFechaFin"]) : "";
        $txtArea = isset($_POST["txtArea"]) ? LimpiarCadena($_POST["txtArea"]) : "";
        $txtSeccion = isset($_POST["txtSeccion"]) ? LimpiarCadena($_POST["txtSeccion"]) : "";

        $respuesta = $frontPrincipal->selectAllLealtadFiltros($agencias, $txtRegion, $txtAgencia, $txtTipoCliente, $txtFechaInicio, $txtFechaFin, $txtArea, $txtSeccion); /* llama a la función del modelo */
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
                "0" => $registrar->SECCION, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
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
        $txtRegion = isset($_POST["txtRegion"]) ? LimpiarCadena($_POST["txtRegion"]) : "";
        $txtAgencia = isset($_POST["txtAgencia"]) ? LimpiarCadena($_POST["txtAgencia"]) : "";
        $txtTipoCliente = isset($_POST["txtTipoCliente"]) ? LimpiarCadena($_POST["txtTipoCliente"]) : "";
        $txtFechaInicio = isset($_POST["txtFechaInicio"]) ? LimpiarCadena($_POST["txtFechaInicio"]) : "";
        $txtFechaFin = isset($_POST["txtFechaFin"]) ? LimpiarCadena($_POST["txtFechaFin"]) : "";
        $txtArea = isset($_POST["txtArea"]) ? LimpiarCadena($_POST["txtArea"]) : "";
        $txtSeccion = isset($_POST["txtSeccion"]) ? LimpiarCadena($_POST["txtSeccion"]) : "";

        $respuesta = $frontPrincipal->selectAllPilaresFiltros($agencias, $txtRegion, $txtAgencia, $txtTipoCliente, $txtFechaInicio, $txtFechaFin, $txtArea, $txtSeccion); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $ASESORIA = Array();
            $CLARIDAD = Array();
            $AMABILIDAD = Array();
            $EMPATIA = Array();
            $EFECTIVIDAD = Array();
            $PERSONALIDAD = Array();
            $AGILIDAD = Array();
            $ACCESIBILIDAD = Array();
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
            //SEMAFORIZACION AMABILIDAD
            if ($registrar->AMABILIDAD >= 80.00 && $registrar->AMABILIDAD <= 100) {
                $AMABILIDAD = array(
                    "0" => $registrar->AMABILIDAD . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->AMABILIDAD >= 60.00 && $registrar->AMABILIDAD <= 79.99) {
                $AMABILIDAD = array(
                    "0" => $registrar->AMABILIDAD . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->AMABILIDAD >= 0.00 && $registrar->AMABILIDAD <= 59.99) {
                $AMABILIDAD = array(
                    "0" => $registrar->AMABILIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            } else {
                $AMABILIDAD = array(
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
            //SEMAFORIZACION PERSONALIZACION
            if ($registrar->PERSONALIZACION >= 80.00 && $registrar->PERSONALIZACION <= 100) {
                $PERSONALIZACION = array(
                    "0" => $registrar->PERSONALIZACION . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->PERSONALIZACION >= 60.00 && $registrar->PERSONALIZACION <= 79.99) {
                $PERSONALIZACION = array(
                    "0" => $registrar->PERSONALIZACION . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->PERSONALIZACION >= 0.00 && $registrar->PERSONALIZACION <= 59.99) {
                $PERSONALIZACION = array(
                    "0" => $registrar->PERSONALIZACION . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            } else {
                $PERSONALIZACION = array(
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
                "0" => $registrar->SECCION, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => ($registrar->ASESORIA == '' || $registrar->ASESORIA == '-') ? '-' : $ASESORIA,
                "2" => ($registrar->CLARIDAD == '' || $registrar->CLARIDAD == '-') ? '-' : $CLARIDAD,
                "3" => ($registrar->AMABILIDAD == '' || $registrar->AMABILIDAD == '-') ? '-' : $AMABILIDAD,
                "4" => ($registrar->EMPATIA == '' || $registrar->EMPATIA == '-') ? '-' : $EMPATIA,
                "5" => ($registrar->EFECTIVIDAD == '' || $registrar->EFECTIVIDAD == '-') ? '-' : $EFECTIVIDAD,
                "6" => ($registrar->PERSONALIZACION == '' || $registrar->PERSONALIZACION == '-') ? '-' : $PERSONALIZACION,
                "7" => ($registrar->AGILIDAD == '' || $registrar->AGILIDAD == '-') ? '-' : $AGILIDAD,
                "8" => ($registrar->ACCESIBILIDAD == '' || $registrar->ACCESIBILIDAD == '-') ? '-' : $ACCESIBILIDAD,
                "9" => ($registrar->VISION == '' || $registrar->VISION == '-') ? '-' : $VISION,
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

    case 'tacometroNPSNegocios':
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
                ROUND((SUM(CASE 
                            WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                            WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                    WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                END)/count(RESPUESTA_11))*100,2) AS NPS
                FROM BGR.TMP g1 WHERE ResultLevel1 LIKE 'CU1%';";
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $NPS = $row["NPS"];
        echo $NPS;
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'tacometroINSNegocios':
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
                    ROUND((SUM(CASE 
                            WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                            WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                    WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                END)/count(RESPUESTA_9))*100,2) AS INS
                FROM BGR.TMP g1 
                WHERE ResultLevel1 LIKE 'CU1%'";
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $INS = $row["INS"];
        echo $INS;
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'tacometroCESNegocios':
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
                ROUND((SUM(CASE 
                            WHEN RESPUESTA_10 = 'MUY FACIL' THEN 0
                    WHEN RESPUESTA_10 = 'POCO FACIL' THEN 1
                    WHEN RESPUESTA_10 = 'FACIL' THEN 0
                    WHEN RESPUESTA_10 = 'DIFICIL' THEN 1
                    WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 1
                END)/count(RESPUESTA_10))*100,2) AS CES
                FROM BGR.TMP g1 WHERE ResultLevel1 LIKE 'CU1%'";
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $CES = $row["CES"];
        echo $CES;
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'tacometroNPSServicios':
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
                ROUND((SUM(CASE 
                            WHEN RESPUESTA_11 >= 9 AND RESPUESTA_11 <= 10 THEN 1
                            WHEN RESPUESTA_11 >= 7 AND RESPUESTA_11 <= 8 THEN 0
                    WHEN RESPUESTA_11 >= 0 AND RESPUESTA_11 <= 6 THEN -1
                END)/count(RESPUESTA_11))*100,2) AS NPS
                FROM BGR.TMP g1 WHERE ResultLevel1 LIKE 'CU1%';";
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $NPS = $row["NPS"];
        echo $NPS;
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'tacometroINSServicios':
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
                    ROUND((SUM(CASE 
                            WHEN RESPUESTA_9 >= 8 AND RESPUESTA_9 <= 10 THEN 1
                            WHEN RESPUESTA_9 >= 5 AND RESPUESTA_9 <= 7 THEN 0
                    WHEN RESPUESTA_9 >= 1 AND RESPUESTA_9 <= 4 THEN -1
                END)/count(RESPUESTA_9))*100,2) AS INS
                FROM BGR.TMP g1 
                WHERE ResultLevel1 LIKE 'CU1%'";
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $INS = $row["INS"];
        echo $INS;
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'tacometroCESServicios':
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
                ROUND((SUM(CASE 
                            WHEN RESPUESTA_10 = 'MUY FACIL' THEN 0
                            WHEN RESPUESTA_10 = 'POCO FACIL' THEN 1
                            WHEN RESPUESTA_10 = 'FACIL' THEN 0
                            WHEN RESPUESTA_10 = 'DIFICIL' THEN 1
                            WHEN RESPUESTA_10 = 'MUY DIFICIL' THEN 1
                END)/count(RESPUESTA_10))*100,2) AS CES
                FROM BGR.TMP g1 WHERE ResultLevel1 LIKE 'CU1%'";
        $value = ejecutarConsulta($sql);
        $row = mysqli_fetch_array($value, MYSQLI_BOTH);
        $CES = $row["CES"];
        echo $CES;
        ejecutarConsulta("DROP TABLE BGR.TMP");
        break;

    case 'selectAllLealtadNegocios':
        $respuesta = $frontPrincipal->selectAllLealtadNegocios($agencias); /* llama a la función del modelo */
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
                "0" => $registrar->SECCION, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
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

    case 'selectAllPilares':
        $respuesta = $frontPrincipal->selectAllPilares($agencias); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $ASESORIA = Array();
            $CLARIDAD = Array();
            $AMABILIDAD = Array();
            $EMPATIA = Array();
            $EFECTIVIDAD = Array();
            $PERSONALIDAD = Array();
            $AGILIDAD = Array();
            $ACCESIBILIDAD = Array();
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
            } else if ($registrar->ASESORIA <= 59.99) {
                $ASESORIA = array(
                    "0" => $registrar->ASESORIA . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->CLARIDAD <= 59.99) {
                $CLARIDAD = array(
                    "0" => $registrar->CLARIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            }
            //SEMAFORIZACION AMABILIDAD
            if ($registrar->AMABILIDAD >= 80.00 && $registrar->AMABILIDAD <= 100) {
                $AMABILIDAD = array(
                    "0" => $registrar->AMABILIDAD . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->AMABILIDAD >= 60.00 && $registrar->AMABILIDAD <= 79.99) {
                $AMABILIDAD = array(
                    "0" => $registrar->AMABILIDAD . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->AMABILIDAD <= 59.99) {
                $AMABILIDAD = array(
                    "0" => $registrar->AMABILIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->EMPATIA <= 59.99) {
                $EMPATIA = array(
                    "0" => $registrar->EMPATIA . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->EFECTIVIDAD <= 59.99) {
                $EFECTIVIDAD = array(
                    "0" => $registrar->EFECTIVIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            }
            //SEMAFORIZACION PERSONALIZACION
            if ($registrar->PERSONALIZACION >= 80.00 && $registrar->PERSONALIZACION <= 100) {
                $PERSONALIZACION = array(
                    "0" => $registrar->PERSONALIZACION . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->PERSONALIZACION >= 60.00 && $registrar->PERSONALIZACION <= 79.99) {
                $PERSONALIZACION = array(
                    "0" => $registrar->PERSONALIZACION . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->PERSONALIZACION <= 59.99) {
                $PERSONALIZACION = array(
                    "0" => $registrar->PERSONALIZACION . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->AGILIDAD <= 59.99) {
                $AGILIDAD = array(
                    "0" => $registrar->AGILIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->ACCESIBILIDAD <= 59.99) {
                $ACCESIBILIDAD = array(
                    "0" => $registrar->ACCESIBILIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->VISION <= 59.99) {
                $VISION = array(
                    "0" => $registrar->VISION . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            }
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->SECCION, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => ($registrar->ASESORIA == '' || $registrar->ASESORIA == '-') ? '-' : $ASESORIA,
                "2" => ($registrar->CLARIDAD == '' || $registrar->CLARIDAD == '-') ? '-' : $CLARIDAD,
                "3" => ($registrar->AMABILIDAD == '' || $registrar->AMABILIDAD == '-') ? '-' : $AMABILIDAD,
                "4" => ($registrar->EMPATIA == '' || $registrar->EMPATIA == '-') ? '-' : $EMPATIA,
                "5" => ($registrar->EFECTIVIDAD == '' || $registrar->EFECTIVIDAD == '-') ? '-' : $EFECTIVIDAD,
                "6" => ($registrar->PERSONALIZACION == '' || $registrar->PERSONALIZACION == '-') ? '-' : $PERSONALIZACION,
                "7" => ($registrar->AGILIDAD == '' || $registrar->AGILIDAD == '-') ? '-' : $AGILIDAD,
                "8" => ($registrar->ACCESIBILIDAD == '' || $registrar->ACCESIBILIDAD == '-') ? '-' : $ACCESIBILIDAD,
                "9" => ($registrar->VISION == '' || $registrar->VISION == '-') ? '-' : $VISION,
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

    case 'selectAllPilaresNegocios':
        $respuesta = $frontPrincipal->selectAllPilaresNegocios($agencias); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $ASESORIA = Array();
            $CLARIDAD = Array();
            $AMABILIDAD = Array();
            $EMPATIA = Array();
            $EFECTIVIDAD = Array();
            $PERSONALIDAD = Array();
            $AGILIDAD = Array();
            $ACCESIBILIDAD = Array();
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
            } else if ($registrar->ASESORIA <= 59.99) {
                $ASESORIA = array(
                    "0" => $registrar->ASESORIA . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->CLARIDAD <= 59.99) {
                $CLARIDAD = array(
                    "0" => $registrar->CLARIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            }
            //SEMAFORIZACION AMABILIDAD
            if ($registrar->AMABILIDAD >= 80.00 && $registrar->AMABILIDAD <= 100) {
                $AMABILIDAD = array(
                    "0" => $registrar->AMABILIDAD . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->AMABILIDAD >= 60.00 && $registrar->AMABILIDAD <= 79.99) {
                $AMABILIDAD = array(
                    "0" => $registrar->AMABILIDAD . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->AMABILIDAD <= 59.99) {
                $AMABILIDAD = array(
                    "0" => $registrar->AMABILIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->EMPATIA <= 59.99) {
                $EMPATIA = array(
                    "0" => $registrar->EMPATIA . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->EFECTIVIDAD <= 59.99) {
                $EFECTIVIDAD = array(
                    "0" => $registrar->EFECTIVIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            }
            //SEMAFORIZACION PERSONALIZACION
            if ($registrar->PERSONALIZACION >= 80.00 && $registrar->PERSONALIZACION <= 100) {
                $PERSONALIZACION = array(
                    "0" => $registrar->PERSONALIZACION . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->PERSONALIZACION >= 60.00 && $registrar->PERSONALIZACION <= 79.99) {
                $PERSONALIZACION = array(
                    "0" => $registrar->PERSONALIZACION . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->PERSONALIZACION <= 59.99) {
                $PERSONALIZACION = array(
                    "0" => $registrar->PERSONALIZACION . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->AGILIDAD <= 59.99) {
                $AGILIDAD = array(
                    "0" => $registrar->AGILIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->ACCESIBILIDAD <= 59.99) {
                $ACCESIBILIDAD = array(
                    "0" => $registrar->ACCESIBILIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->VISION <= 59.99) {
                $VISION = array(
                    "0" => $registrar->VISION . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            }
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->SECCION, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => ($registrar->ASESORIA == '' || $registrar->ASESORIA == '-') ? '-' : $ASESORIA,
                "2" => ($registrar->CLARIDAD == '' || $registrar->CLARIDAD == '-') ? '-' : $CLARIDAD,
                "3" => ($registrar->AMABILIDAD == '' || $registrar->AMABILIDAD == '-') ? '-' : $AMABILIDAD,
                "4" => ($registrar->EMPATIA == '' || $registrar->EMPATIA == '-') ? '-' : $EMPATIA,
                "5" => ($registrar->EFECTIVIDAD == '' || $registrar->EFECTIVIDAD == '-') ? '-' : $EFECTIVIDAD,
                "6" => ($registrar->PERSONALIZACION == '' || $registrar->PERSONALIZACION == '-') ? '-' : $PERSONALIZACION,
                "7" => ($registrar->AGILIDAD == '' || $registrar->AGILIDAD == '-') ? '-' : $AGILIDAD,
                "8" => ($registrar->ACCESIBILIDAD == '' || $registrar->ACCESIBILIDAD == '-') ? '-' : $ACCESIBILIDAD,
                "9" => ($registrar->VISION == '' || $registrar->VISION == '-') ? '-' : $VISION,
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

    case 'selectAllLealtadServicios':
        $respuesta = $frontPrincipal->selectAllLealtadServicios($agencias); /* llama a la función del modelo */
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
                "0" => $registrar->SECCION, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->MUESTRA,
                "2" => $NPS,
                "3" => $INS,
                "4" => $CES,
                "5" => $LEALTAD,
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

    case 'selectAllPilaresServicios':
        $respuesta = $frontPrincipal->selectAllPilaresServicios($agencias); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $ASESORIA = Array();
            $CLARIDAD = Array();
            $AMABILIDAD = Array();
            $EMPATIA = Array();
            $EFECTIVIDAD = Array();
            $PERSONALIDAD = Array();
            $AGILIDAD = Array();
            $ACCESIBILIDAD = Array();
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
            } else if ($registrar->ASESORIA <= 59.99) {
                $ASESORIA = array(
                    "0" => $registrar->ASESORIA . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->CLARIDAD <= 59.99) {
                $CLARIDAD = array(
                    "0" => $registrar->CLARIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            }
            //SEMAFORIZACION AMABILIDAD
            if ($registrar->AMABILIDAD >= 80.00 && $registrar->AMABILIDAD <= 100) {
                $AMABILIDAD = array(
                    "0" => $registrar->AMABILIDAD . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->AMABILIDAD >= 60.00 && $registrar->AMABILIDAD <= 79.99) {
                $AMABILIDAD = array(
                    "0" => $registrar->AMABILIDAD . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->AMABILIDAD <= 59.99) {
                $AMABILIDAD = array(
                    "0" => $registrar->AMABILIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->EMPATIA <= 59.99) {
                $EMPATIA = array(
                    "0" => $registrar->EMPATIA . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->EFECTIVIDAD <= 59.99) {
                $EFECTIVIDAD = array(
                    "0" => $registrar->EFECTIVIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            }
            //SEMAFORIZACION PERSONALIZACION
            if ($registrar->PERSONALIZACION >= 80.00 && $registrar->PERSONALIZACION <= 100) {
                $PERSONALIZACION = array(
                    "0" => $registrar->PERSONALIZACION . '%' . '<img class="img-circle" src="../images/circulo_verde.png" width="14" height="14" alt=""/>',
                );
            } else if ($registrar->PERSONALIZACION >= 60.00 && $registrar->PERSONALIZACION <= 79.99) {
                $PERSONALIZACION = array(
                    "0" => $registrar->PERSONALIZACION . '%' . '<img class="img-circle" src="../images/circulo_amarillo.png" width="18" height="18" alt=""/>',
                );
            } else if ($registrar->PERSONALIZACION <= 59.99) {
                $PERSONALIZACION = array(
                    "0" => $registrar->PERSONALIZACION . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->AGILIDAD <= 59.99) {
                $AGILIDAD = array(
                    "0" => $registrar->AGILIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->ACCESIBILIDAD <= 59.99) {
                $ACCESIBILIDAD = array(
                    "0" => $registrar->ACCESIBILIDAD . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
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
            } else if ($registrar->VISION <= 59.99) {
                $VISION = array(
                    "0" => $registrar->VISION . '%' . '<img class="img-circle" src="../images/circulo_rojo.png" width="12" height="12" alt=""/>',
                );
            }
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->SECCION, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => ($registrar->ASESORIA == '' || $registrar->ASESORIA == '-') ? '-' : $ASESORIA,
                "2" => ($registrar->CLARIDAD == '' || $registrar->CLARIDAD == '-') ? '-' : $CLARIDAD,
                "3" => ($registrar->AMABILIDAD == '' || $registrar->AMABILIDAD == '-') ? '-' : $AMABILIDAD,
                "4" => ($registrar->EMPATIA == '' || $registrar->EMPATIA == '-') ? '-' : $EMPATIA,
                "5" => ($registrar->EFECTIVIDAD == '' || $registrar->EFECTIVIDAD == '-') ? '-' : $EFECTIVIDAD,
                "6" => ($registrar->PERSONALIZACION == '' || $registrar->PERSONALIZACION == '-') ? '-' : $PERSONALIZACION,
                "7" => ($registrar->AGILIDAD == '' || $registrar->AGILIDAD == '-') ? '-' : $AGILIDAD,
                "8" => ($registrar->ACCESIBILIDAD == '' || $registrar->ACCESIBILIDAD == '-') ? '-' : $ACCESIBILIDAD,
                "9" => ($registrar->VISION == '' || $registrar->VISION == '-') ? '-' : $VISION,
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