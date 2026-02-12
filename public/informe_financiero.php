<?php
require_once '../config/Database.php';
require_once '../src/DAO/FinancieroDAO.php'; // Asegúrate de que la ruta sea correcta

// 1. Iniciar sesión y verificar seguridad
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

// 2. CREAR LA CONEXIÓN (Esto es lo que faltaba según el error)
$database = new Database();
$db = $database->getConnection();

// 3. INSTANCIAR EL DAO (Aquí es donde se define la variable del error)
$financieroDAO = new \App\DAO\FinancieroDAO($db);

// 4. OBTENER LOS DATOS PARA LOS INFORMES
$idAnioActivo = $_SESSION['anio_id'];
$resumen = $financieroDAO->obtenerResumenAnual($idAnioActivo);
$morosos = $financieroDAO->obtenerListaMorosos($idAnioActivo);

// A partir de aquí ya puedes poner tu HTML de las tarjetas y la tabla
?>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-none bg-transparent border border-success">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2 pb-1">
                    <div class="avatar me-2">
                        <span class="avatar-initial rounded bg-label-success"><i class="bx bx-dollar"></i></span>
                    </div>
                    <h5 class="ms-1 mb-0">Total Recaudado</h5>
                </div>
                <h4 class="ms-1 mb-0">S/ <?php echo number_format($resumen['recaudado'] ?? 0, 2); ?></h4>
                <p class="mb-0 text-success">Dinero real en caja</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow-none bg-transparent border border-danger">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2 pb-1">
                    <div class="avatar me-2">
                        <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-trending-down"></i></span>
                    </div>
                    <h5 class="ms-1 mb-0">Por Cobrar</h5>
                </div>
                <h4 class="ms-1 mb-0">S/ <?php echo number_format($resumen['pendiente'] ?? 0, 2); ?></h4>
                <p class="mb-0 text-danger">Monto en morosidad</p>
            </div>
        </div>
    </div>
</div>