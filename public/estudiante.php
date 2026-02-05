<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 1. Cargamos el encabezado (Menú, CSS, etc.)
require_once __DIR__ . '/views/layout/header.php';

require_once '../config/Database.php';
require_once '../src/DAO/EstudianteDAO.php';

$database = new Database();
$db = $database->getConnection();
$estudianteDAO = new App\DAO\EstudianteDAO($db);

$estData = null; // Variable para almacenar datos si estamos editando
$isEdit = false;

if (isset($_GET['id'])) {
    $idEditar = $_GET['id'];
    // Necesitas crear este método 'obtenerPorId' en tu EstudianteDAO
    $estData = $estudianteDAO->obtenerPorId($idEditar);
    if ($estData) {
        $isEdit = true;
    }
}

// Configuracion de paginación
$busqueda = isset($_GET['buscar']) ? $_GET['buscar'] : '';
$porPagina = 120;
$paginaActual = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$inicio = ($paginaActual - 1) * $porPagina;

// Pasamos la búsqueda a los métodos
$totalRegistros = $estudianteDAO->contarTotalEstudiantes($busqueda);
$totalPaginas = ceil($totalRegistros / $porPagina);
$listaEstudiantes = $estudianteDAO->listarPaginado($inicio, $porPagina, $busqueda);
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
            <li class="menu-item active">
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
                  <a href="#" class="menu-link">
                    <div data-i18n="Perfect Scrollbar">Año escolar</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="#" class="menu-link">
                    <div data-i18n="Text Divider">Nivel</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="#" class="menu-link">
                    <div data-i18n="Text Divider">Grado</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="#" class="menu-link">
                    <div data-i18n="Text Divider">Sección</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="#" class="menu-link">
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

                <!-- INICIO DEL FORMULARIO -->
                                    
                  <form action="procesar_estudiante.php" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>

                      <input type="hidden" name="idEstudiante" value="<?php echo $isEdit ? $estData['idEstudiante'] : ''; ?>">

                      <div class="nav-align-top mb-4">
                          <ul class="nav nav-tabs" role="tablist">
                              <li class="nav-item">
                                  <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-estudiante" aria-selected="true">Estudiante</button>
                              </li>
                              <li class="nav-item">
                                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-padre" aria-selected="false">Padre</button>
                              </li>
                              <li class="nav-item">
                                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-madre" aria-selected="false">Madre</button>
                              </li>
                              <li class="nav-item">
                                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-apoderado" aria-selected="false">Apoderado/Tutor</button>
                              </li>
                              <li class="nav-item">
                                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-observacion" aria-selected="false">Observación</button>
                              </li>
                          </ul>

                          <div class="tab-content">
                              <div class="tab-pane fade show active" id="navs-estudiante" role="tabpanel">
                                  <div class="row">
                                      <div class="col-md-6 mb-3">
                                          <div class="form-floating">
                                              <input type="text" class="form-control" name="dniEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['dniEstudiante']) : ''; ?>" id="fdni" placeholder="DNI" autofocus required>
                                              <label for="fdni">DNI o Carnet de extranjería</label>
                                              <div class="invalid-tooltip">Obligatorio</div>
                                          </div>
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <div class="form-floating">
                                              <input type="text" class="form-control" name="nombresEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['nombresEstudiante']) : ''; ?>" id="fnames" placeholder="Nombres" required>
                                              <label for="fnames">Nombres</label>
                                              <div class="invalid-tooltip">Obligatorio</div>
                                          </div>
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <div class="form-floating">
                                              <input type="text" class="form-control" name="apellidoPaternoEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['apellidoPaternoEstudiante']) : ''; ?>" id="fapellidoP" placeholder="Apellido Paterno" required>
                                              <label for="fapellidoP">Apellido Paterno</label>
                                              <div class="invalid-tooltip">Obligatorio</div>
                                          </div>
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <div class="form-floating">
                                              <input type="text" class="form-control" name="apellidoMaternoEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['apellidoMaternoEstudiante']) : ''; ?>" id="fapellidoM" placeholder="Apellido Materno" required>
                                              <label for="fapellidoM">Apellido Materno</label>
                                              <div class="invalid-tooltip">Obligatorio</div>
                                          </div>
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <div class="form-floating">
                                              <input type="email" class="form-control" name="emailEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['emailEstudiante']) : ''; ?>" id="femail" placeholder="Correo">
                                              <label for="femail">Correo Electrónico</label>
                                          </div>
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <div class="form-floating">
                                              <input type="date" class="form-control" name="fechaNacimientoEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['fechaNacimientoEstudiante']) : ''; ?>" id="fbirth">
                                              <label for="fbirth">Fecha de Nacimiento</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="tab-pane fade" id="navs-padre" role="tabpanel">
                                  <div class="row">
                                      <div class="col-md-6 mb-3">
                                          <div class="form-floating">
                                              <input type="text" class="form-control" name="dniPadreEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['dniPadreEstudiante']) : ''; ?>" id="dniPadre" placeholder="DNI Padre">
                                              <label for="dniPadre">DNI Padre</label>
                                          </div>
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <div class="form-floating">
                                              <input type="text" class="form-control" name="nombresPadreEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['nombresPadreEstudiante']) : ''; ?>" id="nombresApellidos" placeholder="Nombres">
                                              <label for="nombresApellidos">Nombres y Apellidos del Padre</label>
                                          </div>
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <div class="form-floating">
                                              <input type="tel" class="form-control" name="telefonoPadreEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['telefonoPadreEstudiante']) : ''; ?>" id="celular" placeholder="Celular">
                                              <label for="celular">Celular</label>
                                          </div>
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <div class="form-floating">
                                              <input type="email" class="form-control" name="emailPadreEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['emailPadreEstudiante']) : ''; ?>" id="correoPadre" placeholder="Correo">
                                              <label for="correoPadre">Correo Electrónico</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="tab-pane fade" id="navs-madre" role="tabpanel">
                                  <div class="row">
                                      <div class="col-md-6 mb-3">
                                          <div class="form-floating">
                                              <input type="text" class="form-control" name="dniMadreEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['dniMadreEstudiante']) : ''; ?>" id="dniMadre" placeholder="DNI Madre">
                                              <label for="dniMadre">DNI Madre</label>
                                          </div>
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <div class="form-floating">
                                              <input type="text" class="form-control" name="nombresMadreEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['nombresMadreEstudiante']) : ''; ?>" id="nombresMadre" placeholder="Nombres">
                                              <label for="nombresMadre">Nombres y Apellidos de la Madre</label>
                                          </div>
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <div class="form-floating">
                                              <input type="tel" class="form-control" name="telefonoMadreEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['telefonoMadreEstudiante']) : ''; ?>" id="celularMadre" placeholder="Celular">
                                              <label for="celularMadre">Celular</label>
                                          </div>
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <div class="form-floating">
                                              <input type="email" class="form-control" name="emailMadreEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['emailMadreEstudiante']) : ''; ?>" id="correoMadre" placeholder="Correo">
                                              <label for="correoMadre">Correo Electrónico</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="tab-pane fade" id="navs-apoderado" role="tabpanel">
                                  <div class="row">
                                      <div class="col-md-6 mb-3">
                                          <div class="form-floating">
                                              <input type="text" class="form-control" name="dniTutorEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['dniTutorEstudiante']) : ''; ?>" id="dniApoderado" placeholder="DNI">
                                              <label for="dniApoderado">DNI Tutor</label>
                                          </div>
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <div class="form-floating">
                                              <input type="text" class="form-control" name="nombresTutorEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['nombresTutorEstudiante']) : ''; ?>" id="nombresApoderado" placeholder="Nombres">
                                              <label for="nombresApoderado">Nombres y Apellidos del Tutor</label>
                                          </div>
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <div class="form-floating">
                                              <input type="tel" class="form-control" name="telefonoTutorEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['telefonoTutorEstudiante']) : ''; ?>" id="celularApoderado" placeholder="Celular">
                                              <label for="celularApoderado">Celular</label>
                                          </div>
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <div class="form-floating">
                                              <input type="email" class="form-control" name="emailTutorEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['emailTutorEstudiante']) : ''; ?>" id="correoApoderado" placeholder="Correo">
                                              <label for="correoApoderado">Correo Electrónico</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="tab-pane fade" id="navs-observacion" role="tabpanel">
                                  <div class="col-12 mb-3">
                                      <div class="form-floating">
                                          <textarea class="form-control" name="observacionEstudiante"  id="floatingTextarea" style="height: 100px" placeholder="Observaciones"><?php echo $isEdit ? htmlspecialchars($estData['observacionEstudiante']) : ''; ?></textarea>
                                          <label for="floatingTextarea">Observaciones adicionales</label>
                                      </div>
                                  </div>
                              </div>

                              <button type="submit" class="btn <?php echo $isEdit ? 'btn-warning' : 'btn-success'; ?> btn-md mt-3">
                                  <span class="tf-icons bx bx-plus me-1"></span>
                                  <?php echo $isEdit ? 'Actualizar Estudiante' : 'Agregar Estudiante'; ?>
                              </button>

                              <?php if($isEdit): ?>
                                  <a href="estudiante.php" class="btn btn-outline-secondary btn-md mt-3 ms-2">Cancelar</a>
                              <?php endif; ?>

                          </div>
                      </div>
                  </form>
                                    
                <!-- FIN DEL FORMULARIO --> 

                <!-- INCIO DE LA TABLA --> 
                <div class="card mb-5">
                      <div class="input-group input-group-merge p-3">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Buscar estudiante"
                          aria-describedby="basic-addon-search31"
                          id="buscarEstudiante"
                        />
                      </div>
                  <div class="table-responsive text-nowrap">

                    <table class="table table-hover text-center mb-5">
                      <thead>
                        <tr>
                          <th>DNI</th>
                          <th>Estudiante</th>
                          <th>Ver</th>
                          <th>Editar</th>
                          <th>Matrícula</th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                        <?php if (empty($listaEstudiantes)): ?>
                            <tr>
                                <td colspan="5" class="text-center">No hay estudiantes registrados.</td>
                            </tr>
                        <?php else: ?>
                          <?php foreach ($listaEstudiantes as $est): ?>
                            <tr>
                              <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <?php echo htmlspecialchars($est['dniEstudiante']); ?> </td>
                              <td>
                                <?php 
                                echo htmlspecialchars($est['apellidoPaternoEstudiante'] . ' ' . 
                                     $est['apellidoMaternoEstudiante'] . ', ' . 
                                     $est['nombresEstudiante']); 
                                ?>
                            </td>
                              <td>
                                <div class="d-flex justify-content-center">
                                    <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                      <li
                                        data-bs-toggle="tooltip"
                                        data-popup="tooltip-custom"
                                        data-bs-placement="top"
                                        class="avatar avatar-xs pull-up text-center"
                                        title="Lilian Fuller"
                                      >
                                        <img src="assets/img/avatars/5.png" alt="Avatar" class="rounded-circle" />
                                      </li>
                                    </ul>
                                </div>
                              </td>
                              <td><a href="estudiante.php?id=<?php echo $est['idEstudiante'];?>"><i class="bx bx-edit text-warning"></i></a></td>
                              <td class="text-success"><i class="bx bx-file"></i></td>
                            </tr>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>

                  <div class="card-footer pb-0">
                      <nav aria-label="Page navigation">
                          <ul class="pagination pagination-sm justify-content-center">
                              
                              <li class="page-item <?php echo $paginaActual <= 1 ? 'disabled' : ''; ?>">
                                  <a class="page-link" href="?p=<?php echo $paginaActual - 1; ?>">
                                      <i class="tf-icon bx bx-chevrons-left"></i>
                                  </a>
                              </li>

                              <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                  <li class="page-item <?php echo $i == $paginaActual ? 'active' : ''; ?>">
                                      <a class="page-link" href="?p=<?php echo $i; ?>"><?php echo $i; ?></a>
                                  </li>
                              <?php endfor; ?>

                              <li class="page-item <?php echo $paginaActual >= $totalPaginas ? 'disabled' : ''; ?>">
                                  <a class="page-link" href="?p=<?php echo $paginaActual + 1; ?>">
                                      <i class="tf-icon bx bx-chevrons-right"></i>
                                  </a>
                              </li>
                              
                          </ul>
                      </nav>
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
        <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: '¡Buen trabajo!',
                    text: 'Estudiante registrado con éxito',
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
