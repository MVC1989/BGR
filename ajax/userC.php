<?php

session_start();

require '../models/userM.php';
$user = new User();
date_default_timezone_set("America/Lima");
$date = date('Y-m-d H:i:s');
$userId = $_SESSION['usu'];

$Id = isset($_POST["Id"]) ? LimpiarCadena($_POST["Id"]) : "";
$identificacion = isset($_POST["identificacion"]) ? LimpiarCadena($_POST["identificacion"]) : "";
$Name1 = isset($_POST["Name1"]) ? LimpiarCadena($_POST["Name1"]) : "";
$Name2 = isset($_POST["Name2"]) ? LimpiarCadena($_POST["Name2"]) : "";
$Surname1 = isset($_POST["Surname1"]) ? LimpiarCadena($_POST["Surname1"]) : "";
$Surname2 = isset($_POST["Surname2"]) ? LimpiarCadena($_POST["Surname2"]) : "";
$fecha = isset($_POST["fecha"]) ? LimpiarCadena($_POST["fecha"]) : "";
$adress = isset($_POST["adress"]) ? LimpiarCadena($_POST["adress"]) : "";
$celular = isset($_POST["celular"]) ? LimpiarCadena($_POST["celular"]) : "";
$telefono = isset($_POST["telefono"]) ? LimpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["correo"]) ? LimpiarCadena($_POST["correo"]) : "";
$password = isset($_POST["Password"]) ? LimpiarCadena($_POST["Password"]) : "";
$userGroup = isset($_POST["UserGroup"]) ? LimpiarCadena($_POST["UserGroup"]) : "";
$txtRegion = isset($_POST["txtRegion"]) ? LimpiarCadena($_POST["txtRegion"]) : "";
$agencia = isset($_POST["txtAgenciasAsign"]) ? LimpiarCadena($_POST["txtAgenciasAsign"]) : "";
$state = '1';

switch ($_GET["action"]) {
    case 'selectAll':
        $respuesta = $user->selectAll(); /* llama a la función del modelo */
        $datos = Array(); /* crea un aray para guardar los resultados */
        while ($registrar = $respuesta->fetch_object()) { /* recorre el array */
            $datos[] = array(/* llena los resultados con los datos */
                "0" => $registrar->Id, /* recoge los datos segun los indices de la tabla, iniciando con 0 */
                "1" => $registrar->Id,
                "2" => $registrar->Identification,
                "3" => $registrar->Name1,
                "4" => $registrar->Name2,
                "5" => $registrar->Surname1,
                "6" => $registrar->Surname2,
//                "7" => $registrar->dateBirth,
//                "8" => $registrar->Address,
//                "9" => $registrar->ContacAddress,
//                "10" => $registrar->ContacAddress1,
//                "11" => $registrar->Email,
                "7" => $registrar->UserGroup,
                "8" => $registrar->State,
                "9" => ($registrar->State == 'ACTIVO') ?
                '<center><li class="fa fa-edit" style="color: purple;" onclick="mostrar_uno(\'' . $registrar->Id . '\')"></i>&nbsp;&nbsp;&nbsp; <li class="fa fa-trash" style="color: #3C8DBC;" onclick="desactivar(\'' . $registrar->Id . '\')"></li></center>' :
                '<center><li class="fa fa-edit" style="color: purple;" onclick="mostrar_uno(\'' . $registrar->Id . '\')"></i>&nbsp;&nbsp;&nbsp; <li class="fa fa-refresh" style="color: green;" onclick="activar(\'' . $registrar->Id . '\')" ></li></center>'
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
        $respuesta = $user->selectById($Id);
        echo json_encode($respuesta); /* envia los datos a mostrar mediante json */
        break;

    case 'desactivate':
        $respuesta = $user->desactivate($Id);
        echo $respuesta ? "Usuario eliminado" : "Error: usuario no se pudo eliminar";
        break;

    case 'activate':
        $respuesta = $user->active($Id);
        echo $respuesta ? "Usuario restaurado" : "Error: usuario no se pudo restaurar";
        break;

    case 'insert':
        $respuesta = $user->insert($Id, $name, $password, $state, $userGroup);
        echo $respuesta ? "Usuario registrado" : "Error: usuario no se pudo registrar";
        break;

    case 'update':
        $respuesta = $user->update($Id, $name, $password, $state, $userGroup);
        echo $respuesta ? "Usuario actualizado" : "Error: usuario no se pudo actualizar";
        break;

    case 'desencriptar':
        $texto = isset($_POST["pass"]) ? LimpiarCadena($_POST["pass"]) : "";
        $respuesta = $user->desencriptar($texto);
        echo $respuesta;
        break;

    case 'validarUsuario':
        $user = isset($_POST["IdUser"]) ? LimpiarCadena($_POST["IdUser"]) : "";
        $result = ejecutarConsultaSimple("select Id from user where Id = '$user'");
        $row = $result['Id'];
        echo$row;
        if ($row == '') {
            echo 'SIN INFO';
        } else {
            echo $row;
        }
        break;
        
    case 'cambiarClave':
        $clave = isset($_POST["pass"]) ? LimpiarCadena($_POST["pass"]) : "";
        $usuario = isset($_POST["userId"]) ? LimpiarCadena($_POST["userId"]) : "";
        $nuevaClave = isset($_POST["newPass"]) ? LimpiarCadena($_POST["newPass"]) : "";
        $newPass = $user->encriptar($nuevaClave);
        $result = ejecutarConsultaSimple("select password from user where Id = '$usuario' ");
        $oldPassword = $user->desencriptar($result['password']);
        if ($oldPassword != $clave) {
            echo 'Contraseña incorrecta';
        } else {
            $sql = ejecutarConsulta("UPDATE user SET Password='$newPass' WHERE Id = '$usuario' ");
            echo $sql ? "Contraseña actualizada con éxito" : "Error: no se pudo actualizar contraseña";
        }
        break;

    case 'save':
        $texto = $password;
        $texto1 = $Id;
        $Password = $user->encriptar($texto);
        $User = $user->encriptar($texto1);
        $validate = ejecutarConsulta("select Id from user where Id = '$Id'");
        $valid = mysqli_fetch_array($validate, MYSQLI_BOTH);
        $numRowC = $validate->num_rows;
        if ($numRowC == 0 || $numRowC == '') {
            $respuesta = $user->insert($Id, $identificacion, $Name1, $Name2, $Surname1, $Surname2, $fecha, $User, $Password, $adress, $celular, $telefono, $email, $state, $userId, $date, $userGroup, $txtRegion, $agencia);
            echo $respuesta ? "Usuario registrado" : "Error: usuario no se pudo registrar";
        } else {
            $respuesta = $user->update($Id, $identificacion, $Name1, $Name2, $Surname1, $Surname2, $fecha, $User, $Password, $adress, $celular, $telefono, $email, $state, $userId, $date, $userGroup, $txtRegion, $agencia);
            echo $respuesta ? "Usuario actualizado" : "Error: usuario no se pudo actualizar";
        }
        break;
}
?>

