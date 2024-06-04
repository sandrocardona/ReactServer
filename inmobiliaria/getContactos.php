<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, token, Content-Type, cache-control");
header('Content-Type: application/json');

define("SERVIDOR_BD","lldn295.servidoresdns.net");
define("USUARIO_BD","qaiw208");
define("CLAVE_BD","1PesetaSpain");
define("NOMBRE_BD","qahz656");

/* define("SERVIDOR_BD","localhost");
define("USUARIO_BD","jose");
define("CLAVE_BD","josefa");
define("NOMBRE_BD","bd_inmobiliaria"); */

    //GET DATA
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar a la BD en GET DATA";
        echo $respuesta["error"];
        die();
    }

    try{
        $consulta="SELECT * FROM SANDRO_contacto";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta a la BD en GET DATA";
        $conexion=null;
    }

    if($sentencia->rowCount() > 0){
        /* recoger los datos */
        $respuesta["contactos"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"]="No hay contactos en la BD";
    }

    $sentencia=null;
    $conexion=null;

    echo json_encode($respuesta);
?>