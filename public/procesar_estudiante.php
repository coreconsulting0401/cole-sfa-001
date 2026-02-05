<?php
require_once '../config/Database.php';
require_once '../src/Models/Estudiante.php';
require_once '../src/DAO/EstudianteDAO.php';

use App\Models\Estudiante;
use App\DAO\EstudianteDAO;

session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $estudianteDAO = new EstudianteDAO($db);

    // Capturamos el ID si existe
    $idExistente = !empty($_POST['idEstudiante']) ? (int)$_POST['idEstudiante'] : null;

    $estudiante = new Estudiante(
        idEstudiante: $idExistente, 
        dniEstudiante: $_POST['dniEstudiante'] ?? '',
        nombresEstudiante: $_POST['nombresEstudiante'] ?? '',
        apellidoPaternoEstudiante: $_POST['apellidoPaternoEstudiante'] ?? '',
        apellidoMaternoEstudiante: $_POST['apellidoMaternoEstudiante'] ?? '',
        emailEstudiante: $_POST['emailEstudiante'] ?? null,
        fechaNacimientoEstudiante: $_POST['fechaNacimientoEstudiante'] ?? null,
        fotoEstudiante: null,
        dniPadreEstudiante: $_POST['dniPadreEstudiante'] ?? null,
        nombresPadreEstudiante: $_POST['nombresPadreEstudiante'] ?? null,
        telefonoPadreEstudiante: $_POST['telefonoPadreEstudiante'] ?? null,
        emailPadreEstudiante: $_POST['emailPadreEstudiante'] ?? null,
        dniMadreEstudiante: $_POST['dniMadreEstudiante'] ?? null,
        nombresMadreEstudiante: $_POST['nombresMadreEstudiante'] ?? null,
        telefonoMadreEstudiante: $_POST['telefonoMadreEstudiante'] ?? null,
        emailMadreEstudiante: $_POST['emailMadreEstudiante'] ?? null,
        dniTutorEstudiante: $_POST['dniTutorEstudiante'] ?? null,
        nombresTutorEstudiante: $_POST['nombresTutorEstudiante'] ?? null,
        telefonoTutorEstudiante: $_POST['telefonoTutorEstudiante'] ?? null,
        emailTutorEstudiante: $_POST['emailTutorEstudiante'] ?? null,
        observacionEstudiante: $_POST['observacionEstudiante'] ?? null
    );

    try {
        // DECISIÓN: ¿Actualizar o Registrar?
        if ($idExistente) {
            $resultado = $estudianteDAO->actualizar($estudiante);
        } else {
            $resultado = $estudianteDAO->registrar($estudiante);
        }

        if ($resultado) {
            // Aplicamos tu limpieza de URL para el SweetAlert
            $url_limpia = strtok($_SERVER['HTTP_REFERER'], '?');
            header("Location: " . $url_limpia . "?status=success");
        } else {
            header("Location: estudiante.php?status=error");
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}