<?php
// matricula.php
require_once '../config/Database.php';
require_once '../src/DAO/MatriculaDAO.php';
require_once '../src/DAO/EstudianteDAO.php';

session_start();
// Validación de sesión y año activo
if (!isset($_SESSION['user_id']) || !isset($_SESSION['anio_id'])) {
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$matriculaDAO = new App\DAO\MatriculaDAO($db);


$listaMatriculados = $matriculaDAO->listarMatriculasPorAnio($_SESSION['anio_id']);
$totalMatriculados = $matriculaDAO->obtenerTotalMatriculasPorAnio($_SESSION['anio_id']);

// 1. Cargamos el encabezado (Menú, CSS, etc.)
require_once __DIR__ . '/views/layout/header.php';

?>

    <!-- INICIO DEL DASHBOARD -->
    <div class="layout-wrapper layout-content-navbar">

      <!-- INICIO DEL CONTAINER -->
      <div class="layout-container">
        
        <!-- INICIO DEL MENU VERTICAL -->
            <?php 
           
            require_once __DIR__ . '/views/layout/aside.php'; 

            ?>
        <!-- FIN DEL MENU VERTICAL -->

        <!-- INICIO DEL MENU (USUARIO) Y CONTENIDO MAIN  -->
        <div class="layout-page">

            <!-- INICIO DEL MENU (USUARIO) -->
            <nav
              class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
              id="layout-navbar">
              <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                  <i class="bx bx-menu bx-sm"></i>
                </a>
              </div>

              <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                <!-- Search -->
                <div class="navbar-nav align-items-center">
                    Hola, <?php echo $_SESSION['user_name']." ".$_SESSION['user_apellido_paterno']." ".$_SESSION['user_apellido_materno'];?>
                </div>
                <!-- /Search -->

                <ul class="navbar-nav flex-row align-items-center ms-auto">
                  <!-- INICIO DEL USUARIO -->
                  <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                      <div class="avatar avatar-online">
                        <img src="assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                      </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                        <a class="dropdown-item" href="#">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar avatar-online">
                                <img src="assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <span class="fw-semibold d-block"><?php echo $_SESSION['user_name'];?></span>
                              <small class="text-muted">Admin</small>
                            </div>
                          </div>
                        </a>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#">
                          <i class="bx bx-user me-2"></i>
                          <span class="align-middle">My Profile</span>
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#">
                          <i class="bx bx-cog me-2"></i>
                          <span class="align-middle">Settings</span>
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#">
                          <span class="d-flex align-items-center align-middle">
                            <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                            <span class="flex-grow-1 align-middle">Billing</span>
                            <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                          </span>
                        </a>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                      </li>
                      <li>
                        <a class="dropdown-item" href="logout.php">
                          <i class="bx bx-power-off me-2"></i>
                          <span class="align-middle">Cerrar Sesión</span>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <!-- FIN DEL USUARIO -->
                </ul>
              </div>
            </nav>
            <!-- FIN DEL MENU (USUARIO) -->

            <!-- INICIO DEL CONTENDO -->
            
              <div class="container-xxl container-p-y">

                <!-- INCIO DE LA TABLA --> 
                <div class="card mb-5">

                        <nav aria-label="breadcrumb" class="pt-2 px-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                <a href="javascript:void(0);">Matrícula</a>
                                </li>
                                <li class="breadcrumb-item active">Total: <?php echo $totalMatriculados; ?> </li>
                            </ol>
                        </nav>

                      <div class="input-group input-group-merge p-3">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Buscar matrícula"
                          aria-describedby="basic-addon-search31"
                          id="buscarEstudiante"
                          autofocus
                        />
                      </div>

                    <div class="table-responsive text-nowrap mt-4 mb-3">

                      <table class="table table-hover">
                          <thead>
                              <tr class="text-center">
                                  <th>Estudiantes</th>
                                  <th>Financiero</th>
                                  <th>Matrícula</th>
                                  <th>Año</th>
                                  <th>Libreta</th>
                                  <th>Editar</th>
                                  <th>Estado</th>
                              </tr>
                          </thead>

                        <tbody class="table-border-bottom-0">
                            <?php if (empty($listaMatriculados)): ?>
                                <tr><td colspan="7" class="text-center">No hay matrículas registradas para este año.</td></tr>
                            <?php else: ?>
                                <?php foreach ($listaMatriculados as $mat): ?>
                                <tr>
                                    <td class="text-start">
                                        <div class="d-flex align-items-center">
                                            <img src="assets/img/avatars/5.png" alt="Avatar" class="rounded-circle me-2" width="30">
                                            <span><?php echo htmlspecialchars($mat['apellidoPaternoEstudiante'] .' '. $mat['apellidoMaternoEstudiante'] .' ' . $mat['nombresEstudiante']); ?></span>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <a href="financiero.php?idMatricula=<?php echo $mat['idMatricula']; ?>" 
                                          target="_blank" 
                                          class="btn btn-sm btn-icon btn-outline-primary" 
                                          title="Ver estado financiero">
                                            <i class="bx bx-credit-card"></i>
                                        </a>
                                    </td>
                                    
                                    <td><?php echo $mat['nombreGrado']." ".$mat['nombreSeccion']." ".$mat['nombreNivel']; ?></td>

                                    <td class="text-center"><?php echo $_SESSION['anio_nombre']; ?></td>
                                    
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-icon btn-outline-info">
                                            <i class="bx bx-book-content"></i>
                                        </button>
                                    </td>
                                    
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-icon btn-outline-warning">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="form-check d-flex justify-content-center">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                value="1"
                                                disabled 
                                                id="checkMatricula-<?php echo $mat['estadoMatricula']; ?>" 
                                                <?php echo ($mat['estadoMatricula'] == '1') ? 'checked' : ''; ?> 
                                            />
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>

                      </table>

                  </div>
  

                </div>
                <!-- FIN DE LA TABLA -->

              </div>

            <!-- FIN DEL CONTENDO -->
        </div>

        <!-- FIN DEL  CONTENIDO MAIN -->
      </div>
      <!-- FIN DEL CONTAINER -->

      <div class="layout-overlay layout-menu-toggle"></div> <!-- Oscurece el fondo -->

    </div>
    <!-- FIN DEL DASHBOARD -->
     
    <!-- INICIO DE LOS MENSAJES SWEET -->
        <?php if (isset($_GET['status']) && $_GET['status'] === 'success_matricula'): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: '¡Buen trabajo!',
                    text: 'Matrícula registrado con éxito',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2500
                    }).then(() => {
                        // Esto limpia la URL en el navegador sin recargar la página
                        window.history.replaceState({}, document.title, window.location.pathname);
                    });
            });
        </script>
        <?php endif; ?>
    <!-- FIN DE LOS MENSAJES SWEET -->

<?php 
// 2. Cargamos el pie de página (Scripts JS)
require_once __DIR__ . '/views/layout/footer.php'; 
?>

  <!-- INICIO DEL MODAL PARA LA MATRICULA -->
  <div class="modal fade" id="modalDinamico" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="contenidoModal">
        </div>
    </div>
  </div>
  <!-- FIN DEL MODAL PARA LA MATRICULA -->