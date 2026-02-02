<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


// 1. Cargamos el encabezado (Menú, CSS, etc.)
require_once __DIR__ . '/views/layout/header.php';
?>

    <!-- INICIO DEL DASHBOARD -->
    <div class="layout-wrapper layout-content-navbar">

      <!-- INICIO DEL CONTAINER -->
      <div class="layout-container">
        
        <!-- INICIO DEL MENU VERTICAL -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

          <div class="app-brand demo h-auto d-flex flex-column align-items-center">
                        
            <div class="app-brand demo container d-flex justify-content-center align-items-center">
                <img src="assets/img/logo/logo.png" class="img-fluid" width="70px"><br>               
            </div>
              <style>
              .app-brand-text {
                  /* 1. Cambia el tamaño (ajusta el 1rem a tu gusto) */
                  font-size: 1.2rem !important; 
                  
                  /* 2. Evita que la plantilla lo ponga en mayúsculas automáticamente */
                  text-transform: none !important; 
                  
                  /* 3. Permite que el texto se ajuste si es muy largo */
                  white-space: normal !important;
                  line-height: 1.2;
              }
              </style>             
            <div class="app-brand-text demo menu-text fw-bolder ms-0 text-lowercase-none">I.E.P. San Francisco</div>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>

          </div>

          <hr>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item">

              <a href="dashboard.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Inicio</div>
              </a>

            </li>

            <li class="menu-item">
              <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Basic">Matrícula</div>
              </a>
            </li>

            <!-- ACADÉMICO -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Académico</span></li>
            <!-- REGISTRAR ESTUDIANTES -->
            <li class="menu-item">
              <a href="estudiante.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Basic">Estudiantes</div>
              </a>
            </li>
            <!-- GESTION -->
            <li class="menu-item">
              <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div data-i18n="User interface">Gestión</div>
              </a>
              <ul class="menu-sub">

                <li class="menu-item">
                  <a href="#" class="menu-link">
                    <div data-i18n="Accordion">Accordion</div>
                  </a>
                </li>

              </ul>
            </li>

            <!-- CONFIGURACION -->
            <li class="menu-item active open">
              <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Extended UI">Configuración</div>
              </a>
              <ul class="menu-sub">

                <li class="menu-item">
                  <a href="anio.php" class="menu-link">
                    <div data-i18n="Perfect Scrollbar">Año escolar</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="nivel.php" class="menu-link">
                    <div data-i18n="Text Divider">Nivel</div>
                  </a>
                </li>

                <li class="menu-item active">
                  <a href="grado.php" class="menu-link">
                    <div data-i18n="Text Divider">Grado</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="seccion.php" class="menu-link">
                    <div data-i18n="Text Divider">Sección</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="periodo.php" class="menu-link">
                    <div data-i18n="Text Divider">Periodo</div>
                  </a>
                </li>

              </ul>
            </li>

            <!-- FINANCIERO -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Financiero</span></li>
            <!-- CAJA -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-credit-card"></i>
                <div data-i18n="Form Elements">Caja</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="forms-basic-inputs.html" class="menu-link">
                    <div data-i18n="Basic Inputs">Basic Inputs</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="forms-input-groups.html" class="menu-link">
                    <div data-i18n="Input groups">Input groups</div>
                  </a>
                </li>
              </ul>
            </li>

          </ul>

        </aside>
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
                      <li class="breadcrumb-item active">Grado</li>
                    </ol>
                  </nav>

                  <form id="formRegistroAlineado">
                    <div class="row justify-content-center mt-5 mb-5 p-3">
                      <div class="col-md-6 col-lg-5">
                        
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" id="fNameFull" placeholder="Ingrese Grado" autofocus>
                          <label for="fNameFull">Grado</label>
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
                          <th>Grado</th>
                          <th>Editar</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                      <?php
                      for($i = 0; $i < 9 ; $i++)
                      {
                      ?>
                            <tr>
                              <td><i class="fab fa-angular fa-lg text-danger me-3"></i> 1 ro</td>
                              <td class="text-warning"><i class="bx bx-edit-alt "></i></td>
                            </tr>
                      <?php
                      }
                      ?>
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
     

<?php 
// 2. Cargamos el pie de página (Scripts JS)
require_once __DIR__ . '/views/layout/footer.php'; 
?>
