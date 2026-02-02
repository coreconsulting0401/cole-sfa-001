<?php
namespace App\Controllers;

use App\DAO\UsuarioDAO;

class AuthController {
    private $usuarioDAO;

    public function __construct($db) {
        $this->usuarioDAO = new UsuarioDAO($db);
    }

    public function login($username, $password) {
        $usuario = $this->usuarioDAO->buscarPorUsername($username);

        if ($usuario && password_verify($password, $usuario->passLogin)) {
            // Iniciar sesión
            session_start();
            $_SESSION['user_id'] = $usuario->idLogin;
            $_SESSION['user_name'] = $usuario->nombresLogin;
            $_SESSION['user_apellido_paterno'] = $usuario->apellidoPaternoLogin;
            $_SESSION['user_apellido_materno'] = $usuario->apellidoMaternoLogin;
            $_SESSION['user_acceso_login'] = $usuario->accesoLogin;
            return true;
        }
        return false;
    }
}