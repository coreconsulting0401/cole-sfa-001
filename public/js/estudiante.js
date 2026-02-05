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