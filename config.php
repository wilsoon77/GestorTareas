<?php
date_default_timezone_set('America/Mexico_City'); // Reemplaza con tu zona horaria local
// Configuración de la base de datos
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$base_datos = 'gestor_tareas';

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>
