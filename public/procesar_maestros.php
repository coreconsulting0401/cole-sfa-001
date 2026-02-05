<?php
require_once '../config/Database.php';
require_once '../src/DAO/MaestrosDAO.php';

session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$database = new Database();
$db = $database->getConnection();
$maestrosDAO = new App\DAO\MaestrosDAO($db);

$tipo = $_POST['tipo_registro'] ?? ''; // Campo oculto en tu form
$nombre = $_POST['nombre_dato'] ?? '';
$url_origen = $_SERVER['HTTP_REFERER']; // Para regresar a la misma página

if (!empty($nombre)) {
    $resultado = false;
    
    switch ($tipo) {
        case 'grado':   $resultado = $maestrosDAO->registrarGrado($nombre); break;
        case 'nivel':   $resultado = $maestrosDAO->registrarNivel($nombre); break;
        case 'seccion': $resultado = $maestrosDAO->registrarSeccion($nombre); break;
    }

    if ($resultado) {
        // 1. Obtenemos la URL de donde vino el usuario (ej: grado.php?status=success)
        $url_origen = $_SERVER['HTTP_REFERER'];

        // 2. Limpiamos la URL de cualquier parámetro previo
        $url_limpia = strtok($url_origen, '?'); 

        // 3. Redireccionamos con un único parámetro limpio
        header("Location: " . $url_limpia . "?status=success");
        exit();

    } else {
        $url_limpia = strtok($_SERVER['HTTP_REFERER'], '?');
        header("Location: " . $url_limpia . "?status=error");
        exit();
    }
} else {
    header("Location: " . $url_origen);
}