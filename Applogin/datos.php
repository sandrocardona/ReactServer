<?php
header('Access-Control-Allow-Origin: *');
require "./constantes.php";
require "./conexion.php";

$_POST = json_decode(file_get_contents("php://input"), true);

if ($_POST["telefono"] == $_SESSION["usuario"] && $_POST["password"] == $_SESSION["clave"]) {
    $respuesta["usuario"] = "fulanico";
    $respuesta["mensaje"] = "Acceso correcto";
} else {
    $respuesta["mensaje"] = "Acceso incorrecto";
}

echo json_encode($respuesta);
