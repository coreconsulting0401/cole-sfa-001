<?php
// matricula.php
require_once '../config/Database.php';
require_once '../src/DAO/MatriculaDAO.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$matriculaDAO = new App\DAO\MatriculaDAO($db);

// ... inicialización de DB y DAOs ...
$idAnioActivo = $_SESSION['anio_id'];

// Totales para las tarjetas
$totalGeneral   = $matriculaDAO->obtenerTotalMatriculasPorAnio($idAnioActivo);
$totalInicial   = $matriculaDAO->obtenerTotalPorNivel($idAnioActivo, 1); // ID 1 = Inicial
$totalPrimaria  = $matriculaDAO->obtenerTotalPorNivel($idAnioActivo, 2); // ID 2 = Primaria
$totalSecundaria = $matriculaDAO->obtenerTotalPorNivel($idAnioActivo, 3); // ID 3 = Secundaria
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

        <!-- INICIO DEL MENU (USUARIO) Y CONTENIDO  -->
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
          <div class="content-wrapper">

              <div class="container-xxl flex-grow-1 container-p-y">

                <div class="row">
                    <!-- Inicio del bloque de bienvenida -->
                  <div class="col-lg-9 col-md-12 mb-4 order-0">
                    <div class="card">
                      <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                          <div class="card-body">
                            <h3 class="card-title text-primary">Bienvenido </h3>
                            <p class="mb-4">
                              Estudiantes matriculados <span class="fw-bold">15%</span> más que en 2025.
                            </p>

                          </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                          <div class="card-body pb-0 px-0 px-md-4">
                            <img
                              src="assets/img/illustrations/man-with-laptop-light.png"
                              height="140"
                              alt="View Badge User"
                              data-app-dark-img="illustrations/man-with-laptop-dark.png"
                              data-app-light-img="illustrations/man-with-laptop-light.png"
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Fin del bloque de bienvenida -->

                  <!-- Inicio del bloque de Total -->
                  <div class="col-lg-3 col-md-12  mb-4">
                      <div class="card">
                        <div class="card-body">
                          <h1 class="fw-semibold d-block mb-1">TOTAL</h1>
                          <h3 class="card-title mb-2"><?php echo $totalGeneral;?></h3>
                          estudiantes
                        </div>
                      </div>
                  </div> 
                </div>              
                <!-- Fin del bloque de Total --> 

                <div class="row">
                    <!-- Inicio del bloque de I,P,S --> 
                    <div class="col-lg-12 col-md-4 order-1">
                      <div class="row justify-content-center">

                            <!-- Inicio del bloque de Inicial -->
                              <div class="col-lg-3 col-md-12 col-sm-12 mb-4 d-flex">  
                                <div class="card w-100">
                                  <div class="card-body">
                                    <h3 class="fw-semibold d-block mb-1 text-success">INICIAL</h3>
                                    <h4 class="card-title mb-2 text-success"><?php echo $totalInicial;?></h4>
                                    estudiantes
                                  </div>
                                </div>
                              </div>

                              <!-- Inicio del bloque de Primaria -->
                              <div class="col-lg-3 col-md-12 col-sm-12 mb-4 d-flex">
                                <div class="card w-100">
                                  <div class="card-body">
                                    <h3 class="fw-semibold d-block mb-1 text-warning">PRIMARIA</h3>
                                    <h4 class="card-title mb-2 text-warning"><?php echo $totalPrimaria;?></h4>
                                    estudiantes
                                  </div>
                                </div>
                              </div>

                              <!-- Inicio del bloque de Secundaria -->
                              <div class="col-lg-3 col-md-12 col-sm-12 mb-4 d-flex">
                                <div class="card w-100">
                                  <div class="card-body">
                                    <h3 class="fw-semibold d-block mb-1 text-primary">SECUNDARIA</h3>
                                    <h4 class="card-title mb-2 text-primary"><?php echo $totalSecundaria;?></h4>
                                    estudiantes
                                  </div>
                                </div>
                              </div>

                      </div>
                    </div>
                    <!-- Fin del bloque de I,P,S --> 
                </div>
                
              </div>
          </div>

          
          <!-- FIN DEL CONTENDO -->
        </div>
        <!-- FIN DEL MENU (USUARIO) Y CONTENIDO  -->
      </div>
      <!-- FIN DEL CONTAINER -->

      <div class="layout-overlay layout-menu-toggle"></div> <!-- Oscurece el fondo -->

    </div>
    <!-- FIN DEL DASHBOARD -->


<?php 
// 2. Cargamos el pie de página (Scripts JS)
require_once __DIR__ . '/views/layout/footer.php'; 
?>
