<?php
    require_once 'global.php';
        
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_query( $conexion, 'SET NAMES "'.DB_ENCODE.'"');    
  
    if (mysqli_connect_errno()) {
        printf("Error de conexión: ", mysqli_connect_error());
        exit();
    }
    
    if (!function_exists('ejecutarConsulta')) { /* admin */
        function ejecutarConsulta($sql) {
            global $conexion;
            $query = $conexion->query($sql);
            return $query;
        }

        /*
            Metodo que puede regresar un arreglo de objetos JSON
        */
        function ejecutarJson($sql){
            global $conexion;
            mysqli_set_charset($conexion,"utf8");
            $res_query = mysqli_query($conexion, $sql);   
            $resultado = array();
            while ($producto = $res_query->fetch_assoc()) {
                $resultado[]=$producto;
            }
            if(!empty($resultado))
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
            else{
                $resultado[]="500";
                return json_encode($resultado,JSON_UNESCAPED_UNICODE);
                
            }
        }

        function ejecutarConsultaSimple($sql) {
            global $conexion;
            $query = $conexion->query($sql);
            $row = $query->fetch_assoc();
            return $row;
        }
        
        function ejecutarConsultaRetornarID($sql) {
            global $conexion;
            $query = $conexion->query($sql);
            return $conexion->insert_id;
        }
        
        function LimpiarCadena($str) {
            global $conexion;
            $str = mysqli_real_escape_string($conexion,trim($str));
            return htmlspecialchars($str);
        }
    }

?>