<?php

require '../config/connection.php';

// data sent from form login.php
$Id = isset($_POST["txtUsuario"]) ? LimpiarCadena($_POST["txtUsuario"]) : "";
$password = isset($_POST["txtPass"]) ? LimpiarCadena($_POST["txtPass"]) : "";

function desencriptar($texto) {
    $key = '';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
    list($encrypted_data, $iv) = explode('::', base64_decode($texto), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}

function encriptar($texto) {
    $key = '';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($texto, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

$result = ejecutarConsultaSimple("SELECT u.Id, u.Name1, u.Name2, u.Surname1, u.Surname2, u.dateBirth, u.userId, u.Password, u.State, u.UserGroup, u.Identification, u.Region, u.Agencias FROM user u WHERE u.Id = '$Id'");

// Variable $pass almacena la password del usuario
$pass = desencriptar($result['Password']);
$user = desencriptar($result['userId']);

/*
  verificamos que la clave y usuario ingresada es igual a la de la DB
 */
if ($_POST["txtPass"] == $pass && isset($_POST["txtUsuario"]) == $user) {
    if ($result['State'] == '1') {
        session_start();
        $idSession = session_id();
//    $session = ejecutarConsultaSimple("SELECT SessionId, VirtualCC, Agent, Estado, TmStmp FROM session WHERE Agent = '$Id'");
//    if ($session == "") { //validamos que no tenga sesión abierta en otro navegador
        date_default_timezone_set("America/Lima");
        $_SESSION['loggedin'] = true;
        $_SESSION['usu'] = $user;
        $_SESSION['name'] = $result['Name1'] . ' ' . $result['Surname1'];
        $_SESSION['start'] = date('Y-m-d H:i:s');
        $_SESSION['state'] = 'login';
        $_SESSION['workgroup'] = $result['UserGroup'];
        $_SESSION['idSession'] = $idSession;
        $_SESSION['Identification'] = $result['Identification'];
        $_SESSION['Region'] = $result['Region'];
        $_SESSION['Agencias'] = $result['Agencias'];
        //$_SESSION['expire'] = $_SESSION['start'] + (1 * 60);
        echo "<script>location.href='../views/blank.php' </script>";
        ejecutarConsulta("INSERT INTO session(SessionId, Usuario, Estado, TmStmp) VALUES ('$_SESSION[idSession]','$_SESSION[usu]','$_SESSION[state]','$_SESSION[start]')");
//    } else {
//        echo "<script> alert('Usted ya se encuentra logueado en otro navegador!');
//                location.href='../views/login.php' 
//                </script>";
//    }
    } else {
        echo "<script> alert('Usuario inactivo, comuníquese con el administrador!');
            location.href='../views/login.php' 
            </script>";
    }
} else {
    echo "<script> alert('Usuario o contraseña son incorrectas!');
            location.href='../views/login.php' 
            </script>";
}
?>