<?php
// 1. Importar manualmente las dependencias (Ya que no usamos Autoloading)
require_once '../config/Database.php';
require_once '../src/Models/Usuario.php';
require_once '../src/DAO/UsuarioDAO.php';

// Usamos los namespaces definidos en la tarea anterior
use App\Models\Usuario;
use App\DAO\UsuarioDAO;

echo "<h2>Iniciando prueba de arquitectura MVC/DAO</h2>";

// 2. Probar Conexión
$database = new Database();
$db = $database->getConnection();

if ($db) {
    echo "✅ Conexión a MySQL exitosa.<br>";
} else {
    die("❌ Error en la conexión.");
}

// 3. Probar el DAO
$usuarioDAO = new UsuarioDAO($db);
$userTest = "admin";
$passTest = "admin123";

echo "Buscando al usuario: <b>$userTest</b>...<br>";
$resultado = $usuarioDAO->buscarPorUsername($userTest);

if ($resultado) {
    echo "✅ Usuario encontrado en la BD: " . $resultado->nombresLogin . "<br>";
    
    // 4. Probar verificación de contraseña
    if (password_verify($passTest, $resultado->passLogin)) {
        echo "✅ Verificación de contraseña: <b>Exitosa</b>.<br>";
    } else {
        echo "❌ Verificación de contraseña: <b>Fallida</b>.<br>";
    }
} else {
    echo "❌ El usuario no existe en la base de datos.<br>";
}