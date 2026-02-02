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
            <li class="menu-item active">

              <a href="dashboard.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Inicio</div>
              </a>

            </li>

            <li class="menu-item">
              <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-pencil"></i>
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
                  <a href="ui-accordion.html" class="menu-link">
                    <div data-i18n="Accordion">Accordion</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-alerts.html" class="menu-link">
                    <div data-i18n="Alerts">Alerts</div>
                  </a>
                </li>

              </ul>
            </li>

            <!-- CONFIGURACION -->
            <li class="menu-item">
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

                <li class="menu-item">
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
                <div class="col-lg-8 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div class="col-sm-7">
                        <div class="card-body">
                          <h5 class="card-title text-primary">Bienvenido </h5>
                          <p class="mb-4">
                            Estudiantes matriculados <span class="fw-bold">15%</span> más que en 2025.
                          </p>

                          <a href="#" class="btn btn-md btn-success">Matricula</a>
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

                <!-- Inicio del bloque de Inicial y total-->
                <div class="col-lg-4 col-md-4 order-1">
                  <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">

                          </div>
                          <span class="fw-semibold d-block mb-1">TOTAL</span>
                          <h1 class="card-title mb-2">150 </h1>
                          estudiantes
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img
                                src="assets/img/icons/unicons/wallet-info.png"
                                alt="Credit Card"
                                class="rounded"
                              />
                            </div>
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt6"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                <a class="dropdown-item" href="javascript:void(0);">Ver más</a>
                              </div>
                            </div>
                          </div>
                          <span>Incial</span>
                          <h3 class="card-title text-nowrap mb-1">47</h3>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Fin del bloque de Inicial y total-->
                
                <!-- Inicio del bloque de Primaria y secundaria -->
                <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                  <div class="row">
                    <div class="col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img src="assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded" />
                            </div>
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt4"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                              </div>
                            </div>
                          </div>
                          <span class="d-block mb-1">Primaria</span>
                          <h3 class="card-title text-nowrap mb-2">50</h3>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img src="assets/img/icons/unicons/cc-primary.png" alt="Credit Card" class="rounded" />
                            </div>
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt1"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                <a class="dropdown-item" href="javascript:void(0);">Ver más</a>
                              </div>
                            </div>
                          </div>
                          <span class="fw-semibold d-block mb-1">Secundaria</span>
                          <h3 class="card-title mb-2">70</h3>
                        </div>
                      </div>
                    </div>

        
                  </div>
                </div>
                <!-- Fin del bloque de Primaria y secundaria-->
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
