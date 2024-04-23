<?php

        //variables constantes
        define("SERVIDOR_BD","localhost");
        define("USUARIO_BD","jose");
        define("CLAVE_BD","josefa");
        define("NOMBRE_BD","sc_usuarios");

        try{
            $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible conectar a la BD en login()";
            echo $respuesta["error"];
            die();
        }

        try{
            $consulta="SELECT * FROM sc_usuarios WHERE usuario=? AND clave=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$_POST["telefono"], $_POST["password"]]);
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar la consulta a la BD en login()";
            $conexion=null;
        }

        if($sentencia->rowCount() > 0){
            /* recoger los datos */
            $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);

            /* asignar valor a las variables */
            $usuario=$respuesta["usuario"]["usuario"];
            $clave=md5($respuesta["usuario"]["clave"]);
            $respuesta["api_session"]=session_id();
        } else {
            $respuesta["mensaje"]="Usuario no registrado en la BD";
        }

        $sentencia=null;
        $conexion=null;

        return $respuesta;
?>