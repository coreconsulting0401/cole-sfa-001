<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../src/Models/Usuario.php';
require_once __DIR__ . '/../src/DAO/UsuarioDAO.php';
require_once __DIR__ . '/../src/DAO/MaestrosDAO.php'; // Verificar
require_once __DIR__ . '/../src/Controllers/AuthController.php';

$database = new Database();
$db = $database->getConnection();

// Importante: Verifica que el namespace en AuthController.php sea App\Controllers
$auth = new App\Controllers\AuthController($db);

$user = $_POST['usuario'] ?? '';
$pass = $_POST['password'] ?? '';

if ($auth->login($user, $pass)) {
    header("Location: dashboard.php");
    exit();
} else {
    header("Location: login.php?error=0");
    exit();
}