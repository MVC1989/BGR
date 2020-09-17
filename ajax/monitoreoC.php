<?php

session_start();

require '../models/monitoreoM.php';
$monitoreo = new monitoreoM();
date_default_timezone_set("America/Lima");
$date = date('Y-m-d H:i:s');
$userId = $_SESSION['usu'];
$region = $_SESSION['Region'];
$agencias = $_SESSION['Agencias'];
$rol = $_SESSION['workgroup'];

$Id = isset($_POST["Id"]) ? LimpiarCadena($_POST["Id"]) : ""; //Dato estraido de la funcion mostrar_uno js

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
            $result = ejecutarConsulta("SELECT distinct(NOMBRE_AGENCIA) 'NOMBRE_AGENCIA' FROM agencias where region like '%$txtRegion%' order by NOMBRE_AGENCIA");
            echo '<option value="">Todas</option>';
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                echo '<option value="' . $row["NOMBRE_AGENCIA"] . '">' . $row["NOMBRE_AGENCIA"] . '</option>';
            }
        } else if ($rol == "2") {
            $result = ejecutarConsulta("SELECT distinct(NOMBRE_AGENCIA) 'NOMBRE_AGENCIA' FROM agencias where region like '%$region%' order by NOMBRE_AGENCIA");
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
                        . "where region like '%$region%' and NOMBRE_AGENCIA = '$vAgencia' order by NOMBRE_AGENCIA");
                while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                    echo '<option value="' . $row["NOMBRE_AGENCIA"] . '">' . $row["NOMBRE_AGENCIA"] . '</option>';
                }
            }
        }
        break;

    case 'agenciasList':
        $txtRegion = isset($_POST["txtRegion"]) ? LimpiarCadena($_POST["txtRegion"]) : "";
        if ($rol == "1") {
            $result = ejecutarConsulta("SELECT distinct(NOMBRE_AGENCIA) 'NOMBRE_AGENCIA' FROM agencias where region like '%$txtRegion%' order by NOMBRE_AGENCIA");
            echo '<option value="">Todas</option>';
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                echo '<option value="' . $row["NOMBRE_AGENCIA"] . '">' . $row["NOMBRE_AGENCIA"] . '</option>';
            }
        } else if ($rol == "2") {
            $result = ejecutarConsulta("SELECT distinct(NOMBRE_AGENCIA) 'NOMBRE_AGENCIA' FROM agencias where region like '%$txtRegion%' order by NOMBRE_AGENCIA");
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
                        . "where region like '%$txtRegion%' and NOMBRE_AGENCIA = '$vAgencia' order by NOMBRE_AGENCIA");
                while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
                    echo '<option value="' . $row["NOMBRE_AGENCIA"] . '">' . $row["NOMBRE_AGENCIA"] . '</option>';
                }
            }
        }
        break;

    case 'selectAll':
        $txtRegion = isset($_POST["txtRegion"]) ? LimpiarCadena($_POST["txtRegion"]) : "";
        $txtAgencia = isset($_POST["txtAgencia"]) ? LimpiarCadena($_POST["txtAgencia"]) : "";
        $txtFechaInicio = isset($_POST["txtFechaInicio"]) ? LimpiarCadena($_POST["txtFechaInicio"]) : "";
        $txtFechaFin = isset($_POST["txtFechaFin"]) ? LimpiarCadena($_POST["txtFechaFin"]) : "";
        $txtArea = isset($_POST["txtArea"]) ? LimpiarCadena($_POST["txtArea"]) : "";
        $txtSeccion = isset($_POST["txtSeccion"]) ? LimpiarCadena($_POST["txtSeccion"]) : "";

        $respuesta = $monitoreo->selectAll($agencias, $txtRegion, $txtAgencia, $txtFechaInicio, $txtFechaFin, $txtArea, $txtSeccion); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => '<a href="#" data-toggle="modal" data-target="#calificacionesModal" onclick="mostrar_uno(\'' . $registrar->Id . '\')">Ver registro</a>',
                "1" => $registrar->IDENTIFICACION,
                "2" => $registrar->FECHA,
                "3" => $registrar->REGION,
                "4" => $registrar->AGENCIA,
                "5" => $registrar->SECCION,
                "6" => $registrar->TRANSACCION,
                "7" => $registrar->USUARIO_KMB,
                "8" => $registrar->EVALUADOR,
                "9" => $registrar->EstadoMonitoreo,
                "10" => $registrar->Criterio,
                "11" => $registrar->TMA,
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

    case 'selectById':
        $respuesta = $monitoreo->selectById($Id);
        echo json_encode($respuesta); /* envia los datos a mostrar mediante json */
        break;
}
?>