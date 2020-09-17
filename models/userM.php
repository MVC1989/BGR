<?php

require '../config/connection.php';

Class User {

    public function _construct() { /* Constructor */
    }

    function selectAll() { //mostrar todos los registros
        $sql = "SELECT u.Id, u.Identification, u.Name1, u.Name2, u.Surname1, u.Surname2, u.dateBirth, u.Password, u.Address, 
                u.ContacAddress, u.ContacAddress1, u.Email, u.State, w.Description 'UserGroup',
                case when u.State = 1 then 'ACTIVO' else 'INACTIVO' end 'State'  
                FROM user u, rol w
                where u.UserGroup = w.Id";
        return ejecutarConsulta($sql);
    }

    function insert($Id, $identificacion, $Name1, $Name2, $Surname1, $Surname2, $fecha, $User, $Password, $adress, $celular, $telefono, $email, $state, $userId, $date, $userGroup, $txtRegion, $agencia) { //inserción de datos
        $sql = "INSERT INTO user(Id, VCC, Identification, Name1, Name2, Surname1, Surname2, dateBirth, userId, Password, Address, ContacAddress, ContacAddress1, Email, State, UserGroup, Region, Agencias, UserCreate, TmStmpCreate) VALUES "
                . "('$Id','1','$identificacion','$Name1','$Name2','$Surname1','$Surname2','$fecha','$User','$Password','$adress','$celular','$telefono','$email','$state','$userGroup','$txtRegion','$agencia','$userId', '$date')";
        return ejecutarConsulta($sql);
    }

    function update($Id, $identificacion, $Name1, $Name2, $Surname1, $Surname2, $fecha, $User, $Password, $adress, $celular, $telefono, $email, $state, $userId, $date, $userGroup, $txtRegion, $agencia) { //actualización de datos
        $sql = "UPDATE user SET Identification='$identificacion',Name1='$Name1',Name2='$Name2',Surname1='$Surname1',Surname2='$Surname2',dateBirth='$fecha',userId='$User',Password='$Password',Address='$adress',ContacAddress='$celular',ContacAddress1='$telefono',Email='$email',State='$state',UserGroup='$userGroup',Region='$txtRegion',agencias='$agencia',UserShift='$userId',TmStmpShift='$date' WHERE Id = '$Id'";
        return ejecutarConsulta($sql);
    }

    function desactivate($Id) { //eliminación lógica
        $sql = "UPDATE user SET State= '0' WHERE Id = '$Id'";
        return ejecutarConsulta($sql);
    }

    function active($Id) { //activación lógica
        $sql = "UPDATE user SET State= '1' WHERE Id = '$Id'";
        return ejecutarConsulta($sql);
    }

    function selectById($Id) { //mostrar un registro
        $sql = "SELECT * FROM user where id = '$Id'";
        return ejecutarConsultaSimple($sql);
    }

    function encriptar($texto) {
        $key = '';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($texto, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    function desencriptar($texto) {
        $key = '';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
        list($encrypted_data, $iv) = explode('::', base64_decode($texto), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
    }

}

?>