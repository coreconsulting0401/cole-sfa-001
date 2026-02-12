<?php
/**
 * Procesador de Matrículas y Generación de Plan Financiero
 * Registra la matrícula y crea automáticamente los 13 conceptos de pago.
 */

require_once '../config/Database.php';
require_once '../src/DAO/MatriculaDAO.php';

use App\DAO\MatriculaDAO;

// Seguridad: Verificar sesión
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Inicializar conexión y DAO
    $database = new Database();
    $db = $database->getConnection();
    $matriculaDAO = new MatriculaDAO($db);

    // 2. Capturar y organizar datos del POST en un array
    $datos = [
        'idEstudiante' => isset($_POST['idEstudiante']) ? (int)$_POST['idEstudiante'] : null,
        'idNivel'      => isset($_POST['idNivel'])      ? (int)$_POST['idNivel']      : null,
        'idGrado'      => isset($_POST['idGrado'])      ? (int)$_POST['idGrado']      : null,
        'idSeccion'    => isset($_POST['idSeccion'])    ? (int)$_POST['idSeccion']    : null,
        'idAnio'       => isset($_POST['idAnio'])       ? (int)$_POST['idAnio']       : null
    ];

    // Validación básica de campos obligatorios
    if (!$datos['idEstudiante'] || !$datos['idNivel'] || !$datos['idGrado'] || !$datos['idSeccion'] || !$datos['idAnio']) {
        header("Location: estudiante.php?status=error_campos");
        exit();
    }

    try {
        /**
         * 3. Ejecutar el registro integral
         * Este método ahora maneja la transacción:
         * - Inserta en tabla 'matricula'
         * - Inserta 13 registros en tabla 'financiero' (Matrícula + meses)
         */
        $resultado = $matriculaDAO->registrarMatriculaCompleta($datos);

        if ($resultado === true) {
            // Éxito: Redirigimos a la lista de matriculados
            header("Location: matricula.php?status=success_matricula");
        } else {
            // Si el método devuelve un error específico o false
            error_log("Fallo en registro integral de matrícula");
            header("Location: estudiante.php?status=error_db");
        }
    } catch (Exception $e) {
        // Error inesperado (Base de datos, conexión, etc.)
        error_log("Error crítico en Matrícula: " . $e->getMessage());
        header("Location: estudiante.php?status=error_sistema");
    }
} else {
    // Si alguien intenta entrar directamente al PHP por URL
    header("Location: estudiante.php");
    exit();
}