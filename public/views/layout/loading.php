<div id="loading-overlay">
    <div class="loader-content">
        <div class="spinner-container">
            <div class="dot dot-pastel-green"></div>
            <div class="dot dot-pastel-yellow"></div>
            <div class="dot dot-pastel-red"></div>
            <div class="dot dot-pastel-blue"></div>
        </div>
        <h3 class="loading-text">Cargando...</h3>
        <p id="frase-educativa" class="text-muted fw-italic" style="min-height: 1.5em;"></p>
    </div>
</div>

<style>
#loading-overlay {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background-color: rgba(255, 255, 255, 0.98);
    background-image: url('assets/img/image_dfe174.png'); /* Tu patrón de dibujos */
    background-repeat: repeat;
    display: flex; justify-content: center; align-items: center;
    z-index: 9999;
    transition: opacity 0.6s ease;
}

.loader-content {
    text-align: center;
    background: rgba(255, 255, 255, 0.9);
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
}

.spinner-container { display: flex; justify-content: center; gap: 12px; margin-bottom: 15px; }

.dot { width: 18px; height: 18px; border-radius: 50%; animation: bounce 1.4s infinite ease-in-out both; }

/* Paleta Pastel */
.dot-pastel-green  { background-color: #b2e2f2; animation-delay: -0.32s; } /* Celeste pastel */
.dot-pastel-yellow { background-color: #fdf2b5; animation-delay: -0.16s; } /* Amarillo suave */
.dot-pastel-red    { background-color: #ffcfd2; }                         /* Rosado/Rojo pastel */
.dot-pastel-blue   { background-color: #d1d1f0; animation-delay: 0.16s; }  /* Lavanda */

@keyframes bounce {
    0%, 80%, 100% { transform: scale(0.3); opacity: 0.5; }
    40% { transform: scale(1.1); opacity: 1; }
}

.loading-text { font-family: 'Public Sans', sans-serif; color: #697a8d; font-weight: 700; }
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const frases = [
        "¡Hoy es un gran día para aprender algo nuevo!",
        "La educación es el arma más poderosa para cambiar el mundo.",
        "Cada logro comienza con la decisión de intentarlo.",
        "¡Tu esfuerzo de hoy es tu éxito de mañana!",
        "La curiosidad es la madre de todas las ciencias.",
        "Cree en ti mismo y serás imparable.",
        "Enseñar es dejar una huella en la vida de una persona."
    ];

    // Seleccionar frase aleatoria
    const fraseAleatoria = frases[Math.floor(Math.random() * frases.length)];
    document.getElementById('frase-educativa').innerText = fraseAleatoria;
});

window.addEventListener('load', function() {
    const overlay = document.getElementById('loading-overlay');
    
    // Damos un segundo para que se lea la frase antes de entrar al dashboard
    setTimeout(() => {
        overlay.style.opacity = '0';
        setTimeout(() => {
            overlay.style.display = 'none';
        }, 600);
    }, 1500); 
});
</script>