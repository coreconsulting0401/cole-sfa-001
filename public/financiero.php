<?php
require_once '../config/Database.php';
require_once '../src/DAO/FinancieroDAO.php'; // Importamos el nuevo DAO

if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$database = new Database();
$db = $database->getConnection();
$financieroDAO = new \App\DAO\FinancieroDAO($db); // Instanciamos

// Capturamos el filtro si existe
$idMatriculaFiltro = isset($_GET['idMatricula']) ? (int)$_GET['idMatricula'] : null;

// Obtenemos la data desde el DAO
$pagos = $financieroDAO->listarPagosPorFiltro($_SESSION['anio_id'], $idMatriculaFiltro);

// Agrupamos para la vista
$estudiantesConPagos = [];
foreach ($pagos as $pago) {
    $nombreFull = $pago['apellidoPaternoEstudiante'] . ' ' . $pago['apellidoMaternoEstudiante'] . ', ' . $pago['nombresEstudiante'];
    $estudiantesConPagos[$nombreFull][] = $pago;
}

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
                                <a href="javascript:void(0);">Matrícula <?php echo $_SESSION['anio_nombre']; ?></a>
                                </li>
                                <li class="breadcrumb-item active">Reporte de Pagos </li>
                            </ol>
                        </nav>

                    <div class="table-responsive text-nowrap mt-0 mb-3">

                        <div class="card">
                        
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover">

                                    <thead class="table-primary text-center">
                                        <tr>
                                            <th style="width: 40%;">Concepto</th>
                                            <th style="width: 20%;">Estado</th>
                                            <th style="width: 20%;">Monto</th>
                                            <th style="width: 20%;">Acción</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php if (empty($estudiantesConPagos)): ?>
                                            <tr><td colspan="4" class="text-center">No hay registros financieros para este periodo.</td></tr>
                                        <?php else: ?>
                                            <?php foreach ($estudiantesConPagos as $nombre => $conceptos): ?>
                                              <!-- INICIO DE LA BARRA DE PROGRESO ANUAL DE PAGOS-->
                                              <div class="card-body border-bottom">
                                                  <div class="row align-items-center">
                                                      <div class="col-md-12">
                                                          <h6 class="mb-1">Progreso de Pago Anual</h6>
                                                          <div class="progress" style="height: 20px;">
                                                              <div id="barraProgreso" class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                                                                  role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                                  0%
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                              <!-- FIN DE LA BARRA DE PROGRESO ANUAL DE PAGOS-->
                                                <tr class="table-light">
                                                    <td colspan="4">
                                                        <i class="bx bx-user me-2"></i><strong><?php echo htmlspecialchars($nombre); ?></strong>
                                                    </td>
                                                </tr>
                                                
                                                <?php foreach ($conceptos as $c): ?>
                                                    <tr class="text-center">
                                                        <td class="text-start ps-5"><?php echo htmlspecialchars($c['conceptoFinanciero']); ?></td>
                                                        <td>
                                                            <?php if ($c['estadoFinanciero'] == 'Pendiente'): ?>
                                                                <span class="text-danger fw-bold">Pendiente <i class="bx bx-x-circle"></i></span>
                                                            <?php else: ?>
                                                                <span class="text-success fw-bold">Pagado <i class="bx bx-check-circle"></i></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm mx-auto" style="width: 120px;">
                                                                <span class="input-group-text">S/</span>
                                                                <input type="text" id="monto_<?php echo $c['idFinanciero']; ?>" class="form-control text-end" value="<?php echo number_format($c['montoFinanciero'], 2); ?>">
                                                            </div>
                                                        </td>
                                                        <td>

                                                              <button class="btn btn-sm btn-success btn-pagar-ajax" 
                                                                      data-id="<?php echo $c['idFinanciero']; ?>">
                                                                      PAGAR
                                                              </button>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                    
                                    <tfoot>
                                        <tr class="table-light">
                                            <td colspan="1"></td>
                                            <td class="text-end fw-bold">TOTAL:</td>
                                            <td class="text-center">
                                                <span class="badge bg-label-success fs-6" id="totalPagadoGeneral">
                                                    S/ 0.00
                                                </span>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>

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
     

<?php 
// 2. Cargamos el pie de página (Scripts JS)
require_once __DIR__ . '/views/layout/footer.php'; 
?>

<!-- INICIO DEL SCRIPT PARA EL AJAX DEL PAGO -->
<script>

  $(document).on('click', '.btn-pagar-ajax', function() {
      const btn = $(this);
      const idFin = btn.data('id');
      const montoVal = $('#monto_' + idFin).val();
      const concepto = btn.closest('tr').find('td:first').text().trim();

      if(montoVal <= 0) {
          Swal.fire({
              icon: 'warning',
              title: 'Monto inválido',
              text: 'Por favor, ingrese un monto mayor a 0 antes de procesar el pago.',
              confirmButtonColor: '#ffc107'
          });
          return;
      }

      // Confirmación con SweetAlert
      Swal.fire({
          title: '¿Confirmar Pago?',
          html: `Vas a registrar el pago de <b>${concepto}</b><br>por un monto de: <b>S/ ${montoVal}</b>`,
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#28a745',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sí, cobrar ahora',
          cancelButtonText: 'Cancelar'
      }).then((result) => {
          if (result.isConfirmed) {
              // Mostrar estado de carga
              Swal.fire({
                  title: 'Procesando...',
                  didOpen: () => { Swal.showLoading(); },
                  allowOutsideClick: false
              });

              $.ajax({
                  url: 'procesar_pago.php',
                  type: 'POST',
                  data: { idFinanciero: idFin, monto: montoVal },
                  success: function(response) {
                      if(response.success) {
                          Swal.fire({
                              icon: 'success',
                              title: '¡Pago Registrado!',
                              text: 'El estado se ha actualizado correctamente.',
                              timer: 2000,
                              showConfirmButton: false
                          });

                          // Actualización visual de la fila
                          const fila = btn.closest('tr');
                          // Cambiamos el estado a "Pagado"
                          fila.find('.text-danger').removeClass('text-danger')
                              .addClass('text-success')
                              .html('Pagado <i class="bx bx-check-circle"></i>');

                          actualizarEstadisticasFinancieras();
                          
                      } else {
                          Swal.fire('Error', response.message || 'No se pudo procesar el pago', 'error');
                      }
                  },
                  error: function() {
                      Swal.fire('Error', 'Hubo un problema de conexión con el servidor', 'error');
                  }
              });
          }
      });
  });


  function actualizarEstadisticasFinancieras() {
      let pagadoSuma = 0;
      let pendienteSuma = 0;
      let totalConceptos = 0;
      let conceptosPagados = 0;
      
      $('table tbody tr').each(function() {
          if ($(this).hasClass('table-secondary')) return;

          const monto = parseFloat($(this).find('input').val()) || 0;
          const esPagado = $(this).find('.text-success').length > 0;
          
          totalConceptos++; // Contamos cuántos meses/conceptos hay en total
          
          if (esPagado) {
              pagadoSuma += monto;
              conceptosPagados++; // Contamos cuántos ya están marcados como pagados
          } else {
              pendienteSuma += monto;
          }
      });

      // El porcentaje ahora se basa en CANTIDAD de meses pagados, no en el monto 0
      const porcentaje = totalConceptos > 0 ? (conceptosPagados / totalConceptos) * 100 : 0;

      // Actualizar UI
      $('#totalPagadoGeneral').text('S/ ' + pagadoSuma.toLocaleString('en-US', { minimumFractionDigits: 2 }));
      $('#totalPendiente').text('S/ ' + pendienteSuma.toLocaleString('en-US', { minimumFractionDigits: 2 }));
      
      $('#barraProgreso').css('width', porcentaje + '%')
                        .text(porcentaje.toFixed(0) + '%');

      // Color azul solo si pagó los 13 conceptos
      if(porcentaje >= 100) {
          $('#barraProgreso').removeClass('bg-success').addClass('bg-primary');
      } else {
          $('#barraProgreso').removeClass('bg-primary').addClass('bg-success');
      }
  }

  $(document).ready(function() {
      actualizarEstadisticasFinancieras();
  });

</script>
<!-- FIN DEL SCRIPT PARA EL AJAX DEL PAGO -->