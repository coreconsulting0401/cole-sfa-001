<?php
require_once '../../config/Database.php';
require_once '../../src/DAO/MaestrosDAO.php';

$db = (new Database())->getConnection();
$maestrosDAO = new App\DAO\MaestrosDAO($db);

$idEstudiante = $_POST['id'] ?? '';
$nombreEstudiante = $_POST['nombre'] ?? '';

// Obtener datos para los combos
$niveles = $maestrosDAO->listarNiveles();
$grados = $maestrosDAO->listarGrados();
$secciones = $maestrosDAO->listarSecciones();
$anio = $maestrosDAO->obtenerAnioActivo();

// Si no encuentra nada, evitamos que truene el código
$idAnioActivo = $anio ? $anio['idAnio'] : 0; 
$nombreAnio   = $anio ? $anio['nombreAnio'] : 'No definido';
?>

<div class="modal-header">
    <h5 class="modal-title">Matricular Estudiante: <span class="text-primary"><?php echo $nombreEstudiante; ?></span></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form id="formMatricula" action="procesar_matricula.php" method="POST" class="row g-3 needs-validation" novalidate>
    <div class="modal-body">
        <input type="hidden" name="idEstudiante" value="<?php echo $idEstudiante; ?>">
        
        <div class="row">
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Nivel</label>
                
                <select name="idNivel" class="form-select" required>
                    <option value="">Seleccione...</option>
                    <?php foreach($niveles as $n): ?>
                        <option value="<?php echo $n['idNivel']; ?>"><?php echo $n['nombreNivel']; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Obligatorio</div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Grado</label>
                <select name="idGrado" class="form-select" required>
                    <option value="">Seleccione...</option>
                    <?php foreach($grados as $g): ?>
                        <option value="<?php echo $g['idGrado']; ?>"><?php echo $g['nombreGrado']; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Obligatorio</div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Sección</label>
                <select name="idSeccion" class="form-select" required>
                    <option value="">Seleccione...</option>
                    <?php foreach($secciones as $s): ?>
                        <option value="<?php echo $s['idSeccion']; ?>"><?php echo $s['nombreSeccion']; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Obligatorio</div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Año Escolar (Activo)</label>
                <input type="hidden" name="idAnio" value="<?php echo $idAnioActivo; ?>">
                <input type="text" class="form-control" value="<?php echo $nombreAnio; ?>" readonly>
            </div>

        </div>
    </div>

    <div class="modal-footer">

        <button type="submit" class="btn btn-success">Confirmar Matrícula</button>
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        
    </div>
</form>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
        }

        form.classList.add('was-validated')
        }, false)
    })
    })()
</script>