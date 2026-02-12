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

    <div class="app-brand-text demo menu-text fw-bolder pt-3 text-lowercase-none">I.E.P. San Francisco</div>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>

    </div>

    <hr>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item <?php echo ($pagina_actual == 'dashboard.php') ? 'active' : ''; ?>">

        <a href="dashboard.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Inicio</div>
        </a>

    </li>

    <li class="menu-item <?php echo ($pagina_actual == 'matricula.php') ? 'active' : ''; ?>">
        <a href="matricula.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-file"></i>
        <div data-i18n="Basic">Matrícula <?php echo $_SESSION['anio_nombre']; ?></div>
        </a>
    </li>

    <!-- ACADÉMICO -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Académico</span></li>
    <!-- REGISTRAR ESTUDIANTES -->
    <li class="menu-item <?php echo ($pagina_actual == 'estudiante.php') ? 'active' : ''; ?>"">
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
        <li class="menu-item">
            <a href="#" class="menu-link">
            <div data-i18n="Alerts">Alerts</div>
            </a>
        </li>

        </ul>
    </li>

    <!-- CONFIGURACION -->
    <li class="menu-item <?php echo ($pagina_actual == 'nivel.php' || $pagina_actual == 'grado.php' ||  $pagina_actual == 'seccion.php') ? 'open' : ''; ?>">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div data-i18n="Extended UI">Configuración</div>
        </a>
        <ul class="menu-sub">


        <li class="menu-item <?php echo ($pagina_actual == 'nivel.php') ? 'active' : ''; ?>">
            <a href="nivel.php" class="menu-link">
            <div data-i18n="Text Divider">Nivel</div>
            </a>
        </li>

        <li class="menu-item <?php echo ($pagina_actual == 'grado.php') ? 'active' : ''; ?>">
            <a href="grado.php" class="menu-link">
            <div data-i18n="Text Divider">Grado</div>
            </a>
        </li>

        <li class="menu-item <?php echo ($pagina_actual == 'seccion.php') ? 'active' : ''; ?>">
            <a href="seccion.php" class="menu-link">
            <div data-i18n="Text Divider">Sección</div>
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