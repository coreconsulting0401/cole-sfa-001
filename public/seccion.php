<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 1. Cargamos el encabezado (Menú, CSS, etc.)
require_once __DIR__ . '/views/layout/header.php';

require_once '../config/Database.php';
require_once '../src/DAO/MaestrosDAO.php';

$database = new Database();
$db = $database->getConnection();
$maestrosDAO = new App\DAO\MaestrosDAO($db);

// Obtenemos los datos para las tablas
$listaSecciones = $maestrosDAO->listarSecciones();
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

                <!-- INCIO DEL FORMULARIO Y TABLA --> 
                <div class="card mb-5">

                  <nav aria-label="breadcrumb" class="pt-2 px-2">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Académico</a>
                      </li>
                      <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Configuración</a>
                      </li>
                      <li class="breadcrumb-item active">Sección</li>
                    </ol>
                  </nav>

                  <form action="procesar_maestros.php" method="POST" id="formRegistroAlineado">
                    <div class="row justify-content-center mt-5 mb-5 p-3">
                      <div class="col-md-6 col-lg-5">
                        
                        <input type="hidden" name="tipo_registro" value="seccion">

                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" name="nombre_dato"  id="fNameFull" placeholder="Ingrese Sección" autofocus>
                          <label for="fNameFull">Sección</label>
                        </div>

                        <button type="submit" class="btn btn-success btn-md w-100">
                          <span class="tf-icons bx bx-plus me-1"></span>Agregar
                        </button> 
                        
                      </div>
                    </div>
                  </form>

                  <div class="input-group input-group-merge p-3">
                    <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Buscar"
                      aria-describedby="basic-addon-search31"
                    />
                  </div>

                  <div class="table-responsive text-nowrap">

                    <table class="table table-hover text-center mb-5">
                      <thead>
                        <tr>
                          <th>Sección</th>
                          <th>Editar</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                      <?php foreach ($listaSecciones as $seccion): ?>
                            <tr>
                              <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <?php echo $seccion['nombreSeccion']; ?></td>
                              <td class="text-warning"><i class="bx bx-edit-alt "></i></td>
                            </tr>
                      <?php endforeach; ?>
                      </tbody>
                    </table>

                    <nav aria-label="Page navigation">
                      <ul class="pagination justify-content-center">
                        <li class="page-item prev">
                          <a class="page-link" href="javascript:void(0);"
                            ><i class="tf-icon bx bx-chevrons-left"></i
                          ></a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="javascript:void(0);">1</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="javascript:void(0);">2</a>
                        </li>
                        <li class="page-item active">
                          <a class="page-link" href="javascript:void(0);">3</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="javascript:void(0);">4</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="javascript:void(0);">5</a>
                        </li>
                        <li class="page-item next">
                          <a class="page-link" href="javascript:void(0);"
                            ><i class="tf-icon bx bx-chevrons-right"></i
                          ></a>
                        </li>
                      </ul>
                    </nav>

                  </div>

                </div>
                <!-- FIN DEL FORMULARIO Y TABLA -->

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
        <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: '¡Buen trabajo!',
                    text: 'Sección registrado con éxito',
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
