<?php
// 1. Cargamos el encabezado (Menú, CSS, etc.)
require_once __DIR__ . '/views/layout/header.php';
?>
<style>
    body {
        /* Ruta de tu imagen pequeña */
        background-image: url('assets/img/backgrounds/fondo.png'); 
        
        /* 'repeat' hace que la imagen se repita horizontal y verticalmente */
        background-repeat: repeat;
        
        /* Importante: Para patrones, el tamaño debe ser el original o uno fijo */
        background-size: auto; 
        
        /* Mantiene el fondo estático al mover el scroll */
        background-attachment: fixed;
        
        /* Color base por si la imagen tiene transparencias */
        background-color: #f5f5f9; 
    }

    /* Ajuste para que el contenedor del login resalte sobre el patrón */
    .authentication-wrapper {
        background: transparent;
    }

    .card {
        /* Sombra más pronunciada para que no se pierda con el fondo repetido */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border: 1px solid #d9dee3;
    }
</style>
    <!-- Content -->

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">

              <!-- INICIO DEL MENSAJE DE ERROR -->
             
              <div>
                  <?php 
                      
                      if (isset($_GET['error']) && $_GET['error'] == 0) {
                  ?>
                      <div class="alert alert-danger alert-dismissible" role="alert">
                        Usuario o contraseña incorrectos
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                  <?php     
                    } 
                    if (isset($_GET['status']) && $_GET['status'] == 'success') {
                  ?>
                      <div class="alert alert-success alert-dismissible text-center" role="alert">
                        Hasta pronto 
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                  <?php
                    }
                  ?>
              </div>
              
              <!-- INICIO DEL MENSAJE DE ERROR -->


              <!-- INICIO DEL LOGIN -->
              <form id="formAuthentication" action="procesar_login.php" method="POST" class="mb-3  needs-validation" novalidate>

                <div class="text-center mb-3">
                  <img src="assets/img/logo/logo.png" class="img-fluid" width="140px">
                </div>

                <div class="form-floating mb-3">
                  <input
                    type="text"
                    class="form-control"
                    id="floatingInput"
                    name="usuario"
                    placeholder="Ingrese su usuario"
                    aria-describedby="floatingInputHelp"
                    required
                    autofocus
                  />
                  <label for="floatingInput">Usuario</label>
                  <div class="invalid-tooltip">Obligatorio</div>
                </div>

                <div class="mb-3 form-floating form-password-toggle">
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control form-control-lg"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      required
                      aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    <div class="invalid-tooltip">Obligatorio</div>
                  </div>
                  <label for="floatingInput"></label>
                  
                </div>

                <div class="mb-3">
                  <button class="btn btn-success d-grid w-100" type="submit">Ingresar</button>
                </div>
              </form>
              <!-- FIN DEL LOGIN -->
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->

<!-- INICIO DEL BORRADO DE URL -->
<script>
    // Esperamos 3 segundos (3000ms) para que el usuario pueda leer el mensaje
    setTimeout(function() {
        // Seleccionamos todas las alertas de Bootstrap
        let alerts = document.querySelectorAll('.alert');
        
        alerts.forEach(function(alert) {
            // Usamos la API de Bootstrap para cerrar la alerta con animación
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });

        // Limpiamos la URL (quita el ?status=success o ?error=0)
        const url = new URL(window.location);
        url.search = ''; 
        window.history.replaceState({}, document.title, url.pathname);

    }, 5000); 
</script>
<!-- FIN DEL BORRADO DE URL -->

<?php 
// 2. Cargamos el pie de página (Scripts JS)
require_once __DIR__ . '/views/layout/footer.php'; 
?>
    