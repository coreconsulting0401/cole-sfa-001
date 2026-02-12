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
$porPagina = 100;
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

                <!-- INICIO DEL FORMULARIO -->
                                    
                    <form id="formEstudiante" class="row g-3 needs-validation" novalidate>

                        <input type="hidden" name="idEstudiante" id="idEstudiante" value="<?php echo $isEdit ? $estData['idEstudiante'] : ''; ?>">

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
                                                <input type="text" class="form-control" name="dniEstudiante" id="dniEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['dniEstudiante']) : ''; ?>" placeholder="DNI" autofocus required>
                                                <label for="dniEstudiante">DNI o Carnet de extranjería</label>
                                                <div class="invalid-tooltip">Obligatorio</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="nombresEstudiante" id="nombresEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['nombresEstudiante']) : ''; ?>" placeholder="Nombres" required>
                                                <label for="nombresEstudiante">Nombres</label>
                                                <div class="invalid-tooltip">Obligatorio</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="apellidoPaternoEstudiante" id="apellidoPaternoEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['apellidoPaternoEstudiante']) : ''; ?>" placeholder="Apellido Paterno" required>
                                                <label for="apellidoPaternoEstudiante">Apellido Paterno</label>
                                                <div class="invalid-tooltip">Obligatorio</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="apellidoMaternoEstudiante" id="apellidoMaternoEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['apellidoMaternoEstudiante']) : ''; ?>" placeholder="Apellido Materno" required>
                                                <label for="apellidoMaternoEstudiante">Apellido Materno</label>
                                                <div class="invalid-tooltip">Obligatorio</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="email" class="form-control" name="emailEstudiante" id="emailEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['emailEstudiante']) : ''; ?>" placeholder="Correo">
                                                <label for="emailEstudiante">Correo Electrónico</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="date" class="form-control" name="fechaNacimientoEstudiante" id="fechaNacimientoEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['fechaNacimientoEstudiante']) : ''; ?>" placeholder="Fecha de Nacimiento">
                                                <label for="fechaNacimientoEstudiante">Fecha de Nacimiento</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="navs-padre" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="dniPadreEstudiante" id="dniPadreEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['dniPadreEstudiante']) : ''; ?>" placeholder="DNI Padre">
                                                <label for="dniPadreEstudiante">DNI Padre</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="nombresPadreEstudiante" id="nombresPadreEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['nombresPadreEstudiante']) : ''; ?>" placeholder="Nombres">
                                                <label for="nombresPadreEstudiante">Nombres y Apellidos del Padre</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="tel" class="form-control" name="telefonoPadreEstudiante" id="telefonoPadreEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['telefonoPadreEstudiante']) : ''; ?>" placeholder="Celular">
                                                <label for="telefonoPadreEstudiante">Celular</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="email" class="form-control" name="emailPadreEstudiante" id="emailPadreEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['emailPadreEstudiante']) : ''; ?>" placeholder="Correo">
                                                <label for="emailPadreEstudiante">Correo Electrónico</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="navs-madre" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="dniMadreEstudiante" id="dniMadreEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['dniMadreEstudiante']) : ''; ?>" placeholder="DNI Madre">
                                                <label for="dniMadreEstudiante">DNI Madre</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="nombresMadreEstudiante" id="nombresMadreEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['nombresMadreEstudiante']) : ''; ?>" placeholder="Nombres">
                                                <label for="nombresMadreEstudiante">Nombres y Apellidos de la Madre</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="tel" class="form-control" name="telefonoMadreEstudiante" id="telefonoMadreEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['telefonoMadreEstudiante']) : ''; ?>" placeholder="Celular">
                                                <label for="telefonoMadreEstudiante">Celular</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="email" class="form-control" name="emailMadreEstudiante" id="emailMadreEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['emailMadreEstudiante']) : ''; ?>" placeholder="Correo">
                                                <label for="emailMadreEstudiante">Correo Electrónico</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="navs-apoderado" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="dniTutorEstudiante" id="dniTutorEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['dniTutorEstudiante']) : ''; ?>" placeholder="DNI">
                                                <label for="dniTutorEstudiante">DNI Tutor</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="nombresTutorEstudiante" id="nombresTutorEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['nombresTutorEstudiante']) : ''; ?>" placeholder="Nombres">
                                                <label for="nombresTutorEstudiante">Nombres y Apellidos del Tutor</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="tel" class="form-control" name="telefonoTutorEstudiante" id="telefonoTutorEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['telefonoTutorEstudiante']) : ''; ?>" placeholder="Celular">
                                                <label for="telefonoTutorEstudiante">Celular</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating">
                                                <input type="email" class="form-control" name="emailTutorEstudiante" id="emailTutorEstudiante" value="<?php echo $isEdit ? htmlspecialchars($estData['emailTutorEstudiante']) : ''; ?>" placeholder="Correo">
                                                <label for="emailTutorEstudiante">Correo Electrónico</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="navs-observacion" role="tabpanel">
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" name="observacionEstudiante" id="observacionEstudiante" style="height: 100px" placeholder="Observaciones"><?php echo $isEdit ? htmlspecialchars($estData['observacionEstudiante']) : ''; ?></textarea>
                                            <label for="observacionEstudiante">Observaciones adicionales</label>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn <?php echo $isEdit ? 'btn-warning' : 'btn-success'; ?> btn-md mt-3">
                                    <span class="tf-icons bx bx-save me-1"></span>
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

                      <table class="table table-hover mb-5">
                          <thead>
                              <tr class="text-center">
                                  <th>DNI</th>
                                  <th>Estudiante</th>
                                  <th>Ver</th>
                                  <th>Editar</th>
                                  <th>Matrícula <?php echo $_SESSION['anio_nombre']; ?></th>
                              </tr>
                          </thead>
                          <tbody id="tablaEstudiantesBody" class="table-border-bottom-0">
                              <?php if (empty($listaEstudiantes)): ?>
                                  <tr>
                                      <td colspan="5" class="text-center">No hay estudiantes registrados.</td>
                                  </tr>
                              <?php else: ?>
                                  <?php foreach ($listaEstudiantes as $est): 
                                      // Verificamos si ya está matriculado en el año activo
                                      $yaMatriculado = $estudianteDAO->verificarMatriculaActiva($est['idEstudiante'], $_SESSION['anio_id']); 
                                  ?>
                                      <tr>
                                          <td class="text-center">
                                              <i class="fab fa-angular fa-lg text-danger me-3"></i> 
                                              <strong><?php echo htmlspecialchars($est['dniEstudiante']); ?></strong>
                                          </td>

                                          <td>
                                              <?php 
                                              echo htmlspecialchars($est['apellidoPaternoEstudiante'] . ' ' . 
                                                  $est['apellidoMaternoEstudiante'] . ', ' . 
                                                  $est['nombresEstudiante']); 
                                              ?>
                                          </td>

                                          <td class="text-center">
                                              <div class="d-flex justify-content-center">
                                                  <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                                      <li data-bs-toggle="tooltip"
                                                          data-popup="tooltip-custom"
                                                          data-bs-placement="top"
                                                          class="avatar avatar-xs pull-up"
                                                          title="Ver detalle de <?php echo htmlspecialchars($est['nombresEstudiante']); ?>">
                                                          <img src="assets/img/avatars/5.png" alt="Avatar" class="rounded-circle" />
                                                      </li>
                                                  </ul>
                                              </div>
                                          </td>

                                          <td class="text-center">
                                              <a href="estudiante.php?id=<?php echo $est['idEstudiante'];?>" class="btn btn-sm btn-icon btn-outline-warning">
                                                  <i class="bx bx-edit"></i>
                                              </a>
                                          </td>

                                          <td class="text-center">
                                              <div class="d-flex justify-content-center">
                                                  <?php if ($yaMatriculado): ?>
                                                      <button type="button" class="btn btn-sm btn-icon btn-success" title="Matrícula ya registrada" disabled>
                                                          <i class="bx bx-check-double"></i>
                                                      </button>
                                                  <?php else: ?>
                                                      <button type="button"
                                                              data-bs-toggle="tooltip" 
                                                              data-popup="tooltip-custom"
                                                              data-bs-placement="top"
                                                              title="Realizar matrícula"
                                                              class="btn btn-sm btn-icon btn-outline-success btn-matricular" 
                                                              data-id="<?php echo $est['idEstudiante']; ?>"
                                                              data-nombre="<?php echo htmlspecialchars($est['apellidoPaternoEstudiante'] . ' ' . $est['nombresEstudiante']); ?>"
                                                              title="Realizar Matrícula">
                                                          <i class="bx bx-file"></i>
                                                      </button>
                                                  <?php endif; ?>
                                              </div>
                                          </td>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formEstudiante');
        const tablaBody = document.getElementById('tablaEstudiantesBody');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            const formData = new FormData(form);

            fetch('./procesar_estudiante.php', { 
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error('Error en la respuesta del servidor');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.isEdit ? 'Estudiante actualizado' : 'Estudiante registrado correctamente',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    if (data.isEdit) {
                        // En edición recargamos para refrescar cambios en toda la fila de forma segura
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        // SI ES NUEVO: Agregamos la fila dinámicamente
                        if (data.estudiante) {
                            agregarFilaATabla(data.estudiante);
                        }
                        
                        // Limpiar formulario y estados de validación
                        form.reset();
                        form.classList.remove('was-validated');
                        
                        // Opcional: Volver a la primera pestaña (Estudiante)
                        const firstTab = document.querySelector('#formEstudiante .nav-link:first-child');
                        if (firstTab) bootstrap.Tab.getOrCreateInstance(firstTab).show();
                    }
                } else {
                    Swal.fire('Atención', data.message || 'Error al procesar', 'warning');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error crítico', 'No se pudo conectar con el servidor o el formato de respuesta es inválido.', 'error');
            });
        });

        function agregarFilaATabla(est) {
            // 1. Eliminar el mensaje de "No hay estudiantes" si existe
            if (tablaBody.innerHTML.includes('colspan="5"')) {
                tablaBody.innerHTML = '';
            }

            // 2. Construir la fila con el formato exacto de tu tabla
            const nuevaFila = `
                <tr>
                    <td class="text-center">
                        <i class="fab fa-angular fa-lg text-danger me-3"></i> 
                        <strong>${est.dniEstudiante}</strong>
                    </td>
                    <td>
                        ${est.apellidoPaternoEstudiante} ${est.apellidoMaternoEstudiante}, ${est.nombresEstudiante}
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                <li class="avatar avatar-xs pull-up" title="Ver detalle de ${est.nombresEstudiante}">
                                    <img src="assets/img/avatars/5.png" alt="Avatar" class="rounded-circle" />
                                </li>
                            </ul>
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="estudiante.php?id=${est.idEstudiante}" class="btn btn-sm btn-icon btn-outline-warning">
                            <i class="bx bx-edit"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <button type="button" 
                                    class="btn btn-sm btn-icon btn-outline-success btn-matricular" 
                                    data-id="${est.idEstudiante}" 
                                    data-nombre="${est.apellidoPaternoEstudiante} ${est.nombresEstudiante}"
                                    title="Realizar Matrícula">
                                <i class="bx bx-file"></i>
                            </button>
                        </div>
                    </td>
                </tr>`;
            
            // 3. Insertar al principio de la tabla para que el usuario vea el cambio de inmediato
            tablaBody.insertAdjacentHTML('afterbegin', nuevaFila);
            
            // 4. Inicializar tooltips de Bootstrap si los usas para la nueva fila
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltips.forEach(t => new bootstrap.Tooltip(t));
        }
    });
</script>
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