<?php
// 1. Cargamos el encabezado (Menú, CSS, etc.)
require_once __DIR__ . '/views/layout/header.php';
?>

    <!-- Content -->

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">

              <!-- INICIO DEL LOGIN -->
              <form id="formAuthentication" class="mb-3" action="procesar_login.php" method="POST">

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
                    autofocus
                  />
                  <label for="floatingInput">Usuario</label>

                </div>

                <div class="mb-3 form-floating form-password-toggle">
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control form-control-lg"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                  <label for="floatingInput"></label>
                </div>

                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Ingresar</button>
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

<?php 
// 2. Cargamos el pie de página (Scripts JS)
require_once __DIR__ . '/views/layout/footer.php'; 
?>
    