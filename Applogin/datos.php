<?php
    header('Access-Control-Allow-Origin: *');

    //variables constantes
    define("SERVIDOR_BD","localhost");
    define("USUARIO_BD","jose");
    define("CLAVE_BD","josefa");
    define("NOMBRE_BD","applogin_react");


    $_POST = json_decode(file_get_contents("php://input"), true);

    $usuario=$_POST["telefono"];
    $clave=md5($_POST["password"]);

    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $answer["error"]="Imposible conectar a la BD en login()";
    }
    try{
        $consulta="SELECT * FROM sc_usuarios WHERE usuario=? AND clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    }
    catch(PDOException $e){
        $answer["error"]="Imposible realizar la consulta a la BD en login()";
        $conexion=null;
    }
    if($sentencia->rowCount() > 0){
        /* recoger los datos */
        $answer["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        /* asignar valor a las variables */
        $respuesta["usuario"]=$answer["usuario"]["usuario"];
    } else {
        $answer["mensaje"]="Usuario no registrado en la BD";
    }

echo json_encode($respuesta);
