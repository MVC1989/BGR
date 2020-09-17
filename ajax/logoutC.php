<?php

require '../config/connection.php';
session_start();
date_default_timezone_set("America/Lima");
$_SESSION['usu'];
$_SESSION['name'];
$_SESSION['state'];
$enddate = date('Y-m-d H:i:s');
$_SESSION['workgroup'];
$_SESSION['idSession'];

$deleteSession = ejecutarConsulta("DELETE FROM session WHERE "
//        . "SessionId = '$_SESSION[idSession]' and "
        . "Usuario = '$_SESSION[usu]' ");

// -- eliminamos la sesión del usuario
if (isset($_SESSION['usu'])) {
    unset($_SESSION['usu']);
    unset($_SESSION['name']);
    unset($_SESSION['state']);
    unset($_SESSION['workgroup']);
    unset($_SESSION['idSession']);
}
if(isset($_SESSION['usu']) == false){
    session_regenerate_id();
}
session_destroy();
header('location: ../views/login.php');
exit();
?>
