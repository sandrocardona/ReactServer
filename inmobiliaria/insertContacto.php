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
$respuesta = array();

try {
    $conexion = new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    
} catch (PDOException $e) {
    $respuesta["error"] = "Imposible conectar a la BD en GET insertContacto: " . $e->getMessage();
    echo json_encode($respuesta);
    die();
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['nombre']) && isset($data['telefono']) && isset($data['idPropiedad'])) {
    $nombre = $data['nombre'];
    $telefono = $data['telefono'];
    $id_propiedad = $data['idPropiedad'];

    try {
        $consulta = "INSERT INTO SANDRO_contacto (nombre, telefono, id_propiedad) VALUES (:nombre, :telefono, :id_propiedad)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->bindParam(':nombre', $nombre);
        $sentencia->bindParam(':telefono', $telefono);
        $sentencia->bindParam(':id_propiedad', $id_propiedad);
        $sentencia->execute();

        $respuesta["message"] = "Registro insertado con éxito";
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible realizar la consulta a la BD en insertContacto: " . $e->getMessage();
    }

    $sentencia = null;
} else {
    $respuesta["error"] = "Datos insuficientes para realizar la inserción";
}

$conexion = null;

echo json_encode($respuesta);
?>
