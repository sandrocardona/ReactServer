<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, token, Content-Type, cache-control");
header('Content-Type: application/json');

define("SERVIDOR_BD","localhost");
define("USUARIO_BD","jose");
define("CLAVE_BD","josefa");
define("NOMBRE_BD","bd_inmobiliaria");

$respuesta = array();

try {
    $conexion = new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    
} catch (PDOException $e) {
    $respuesta["error"] = "Imposible conectar a la BD en GET insertContacto: " . $e->getMessage();
    echo json_encode($respuesta);
    die();
}

$data = json_decode(file_get_contents("php://input"), true);

if (
    isset($data['idTipo']) &&
    isset($data['idViviendas']) &&
    isset($data['idVenta']) &&
    isset($data['localidad']) &&
    isset($data['estado']) &&
    isset($data['titulo']) &&
    isset($data['informacion']) &&
    isset($data['metros']) &&
    isset($data['precio']) &&
    isset($data['habitaciones']) &&
    isset($data['bannos']) &&
    isset($data['piscina']) &&
    isset($data['garaje']) &&
    isset($data['trastero']) &&
    isset($data['foto']) &&
    isset($data['telefono']) &&
    isset($data['nombre'])
) {
    $id_tipo = $data['idTipo'];
    $id_viviendas = $data['idViviendas'];
    $id_venta = $data['idVenta'];
    $localidad = $data['localidad'];
    $estado = $data['estado'];
    $titulo = $data['titulo'];
    $informacion = $data['informacion'];
    $metros = (float)$data['metros'];
    $precio = (float)$data['precio'];
    $habitaciones = $data['habitaciones'];
    $bannos = $data['bannos'];
    $piscina = $data['piscina'];
    $garaje = $data['garaje'];
    $trastero = (float)$data['trastero'];
    $foto = $data['foto'];
    $telefono = $data['telefono'];
    $nombre = $data['nombre'];


    try {
        $consulta = "INSERT INTO propiedades (
                id_tipo,
                id_viviendas,
                id_venta,
                localidad,
                estado,
                titulo,
                informacion,
                metros,
                precio,
                habitaciones,
                bannos,
                piscina,
                garaje,
                trastero,
                foto,
                telefono,
                nombre
            )
            VALUES (
                :id_tipo, 
                :id_viviendas, 
                :id_venta, 
                :localidad, 
                :estado, 
                :titulo, 
                :informacion, 
                :metros, 
                :precio, 
                :habitaciones, 
                :bannos, 
                :piscina, 
                :garaje, 
                :trastero, 
                :foto, 
                :telefono, 
                :nombre
            )";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':id_tipo', $id_tipo);
        $stmt->bindParam(':id_viviendas', $id_viviendas);
        $stmt->bindParam(':id_venta', $id_venta);
        $stmt->bindParam(':localidad', $localidad);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':informacion', $informacion);
        $stmt->bindParam(':metros', $metros);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':habitaciones', $habitaciones);
        $stmt->bindParam(':bannos', $bannos);
        $stmt->bindParam(':piscina', $piscina);
        $stmt->bindParam(':garaje', $garaje);
        $stmt->bindParam(':trastero', $trastero);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();

        $respuesta["message"] = "Registro insertado con éxito";
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible realizar la consulta a la BD en insertContacto: " . $e->getMessage();
    }

    $stmt = null;
} else {
    $respuesta["error"] = "Datos insuficientes para realizar la inserción";
}

$conexion = null;

echo json_encode($respuesta);
?>