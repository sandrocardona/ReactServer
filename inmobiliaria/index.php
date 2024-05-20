<?php
    header('Access-Control-Allow-Origin: *');

    define("SERVIDOR_BD","localhost");
    define("USUARIO_BD","jose");
    define("CLAVE_BD","josefa");
    define("NOMBRE_BD","TEST_n0_REACT");

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
        $consulta="SELECT * FROM propiedades";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible realizar la consulta a la BD en GET DATA";
        $conexion=null;
    }

    if($sentencia->rowCount() > 0){
        /* recoger los datos */
        $respuesta["propiedades"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"]="Usuario no registrado en la BD";
    }

    $sentencia=null;
    $conexion=null;

    echo json_encode($respuesta);
?>