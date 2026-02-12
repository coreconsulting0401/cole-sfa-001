<?php
require_once '../config/Database.php';
require_once '../src/Models/Estudiante.php';
require_once '../src/DAO/EstudianteDAO.php';

use App\Models\Estudiante;
use App\DAO\EstudianteDAO;

header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no iniciada']);
    exit;
}

$database = new Database();
$db = $database->getConnection();
$estudianteDAO = new EstudianteDAO($db);

$action = $_GET['action'] ?? 'guardar';

// ACCIÓN: LISTAR PARA LA TABLA
if ($action === 'listar') {
    $busqueda = $_GET['buscar'] ?? '';
    // Reutilizamos tu lógica de paginación o traemos los últimos 100
    $lista = $estudianteDAO->listarPaginado(0, 100, $busqueda);
    
    // Añadimos info de matrícula para cada estudiante
    foreach ($lista as &$est) {
        $est['yaMatriculado'] = $estudianteDAO->verificarMatriculaActiva($est['idEstudiante'], $_SESSION['anio_id']);
    }
    
    echo json_encode($lista);
    exit;
}

// ACCIÓN: GUARDAR/ACTUALIZAR
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idExistente = !empty($_POST['idEstudiante']) ? (int)$_POST['idEstudiante'] : null;

    $estudiante = new Estudiante(
        idEstudiante: $idExistente, 
        dniEstudiante: $_POST['dniEstudiante'] ?? '',
        nombresEstudiante: $_POST['nombresEstudiante'] ?? '',
        apellidoPaternoEstudiante: $_POST['apellidoPaternoEstudiante'] ?? '',
        apellidoMaternoEstudiante: $_POST['apellidoMaternoEstudiante'] ?? '',
        emailEstudiante: $_POST['emailEstudiante'] ?? null,
        fechaNacimientoEstudiante: $_POST['fechaNacimientoEstudiante'] ?? null,
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
        if ($idExistente) {
            $exito = $estudianteDAO->actualizar($estudiante);
            echo json_encode(['success' => $exito, 'isEdit' => true]);
        } else {
            // Aquí capturamos el ID que ahora devuelve el DAO
            $nuevoId = $estudianteDAO->registrar($estudiante); 
            
            if ($nuevoId) {
                echo json_encode([
                    'success' => true,
                    'isEdit' => false,
                    'estudiante' => [
                        'idEstudiante' => $nuevoId,
                        'dniEstudiante' => $_POST['dniEstudiante'],
                        'nombresEstudiante' => $_POST['nombresEstudiante'],
                        'apellidoPaternoEstudiante' => $_POST['apellidoPaternoEstudiante'],
                        'apellidoMaternoEstudiante' => $_POST['apellidoMaternoEstudiante']
                    ]
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al insertar en DB']);
            }
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}