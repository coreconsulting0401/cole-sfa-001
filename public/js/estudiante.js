document.addEventListener('DOMContentLoaded', function() {
    const inputBuscar = document.getElementById('buscarEstudiante');
    // Seleccionamos específicamente las filas del cuerpo de la tabla de estudiantes
    const tablaEstudiantes = document.querySelector('.table-responsive table tbody');

    if (inputBuscar && tablaEstudiantes) {
        inputBuscar.addEventListener('keyup', function(e) {
            const texto = e.target.value.toLowerCase();
            const filas = tablaEstudiantes.querySelectorAll('tr');

            filas.forEach(fila => {
                const contenidoFila = fila.textContent.toLowerCase();
                if (contenidoFila.includes(texto)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    }
});

$(document).on('click', '.btn-matricular', function(e) {
    e.preventDefault();
    
    // 1. Verificar si captura los datos
    const idEst = $(this).data('id');
    const nomEst = $(this).data('nombre');
    
    console.log("Iniciando matrícula para ID:", idEst);

    // 2. Llamada AJAX
    $.ajax({
        url: 'modals/modal_matricula.php', 
        type: 'POST',
        data: { id: idEst, nombre: nomEst },
        beforeSend: function() {
            console.log("Enviando petición al servidor...");
        },
        success: function(response) {
            // Inyectar HTML
            $('#contenidoModal').html(response);
            
            // --- CORRECCIÓN PARA BLOQUEAR FONDO ---
            // Primero intentamos obtener la instancia existente para evitar duplicados de backdrop
            let modalElement = document.getElementById('modalDinamico');
            let modalInstancia = bootstrap.Modal.getInstance(modalElement);

            if (!modalInstancia) {
                // Si no existe la instancia, la creamos con las opciones de bloqueo
                modalInstancia = new bootstrap.Modal(modalElement, {
                    backdrop: 'static',
                    keyboard: false
                });
            }
            
            // Mostrar el modal
            modalInstancia.show();
            // ---------------------------------------
        },
        error: function(xhr, status, error) {
            console.error("Error AJAX:", status, error);
            alert("Error al cargar: " + error + ". Revisa que 'modals/modal_matricula.php' exista.");
        }
    });
});
