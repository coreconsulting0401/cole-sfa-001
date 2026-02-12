<?php
namespace App\Controllers;

use App\DAO\UsuarioDAO;
use App\DAO\MaestrosDAO; // Importamos el DAO de Maestros

class AuthController {
    private $usuarioDAO;
    private $maestrosDAO; // Añadimos la propiedad

    public function __construct($db) {
        $this->usuarioDAO = new UsuarioDAO($db);
        $this->maestrosDAO = new MaestrosDAO($db); // Inicializamos el DAO de Maestros
    }

    public function login($username, $password) {
        $usuario = $this->usuarioDAO->buscarPorUsername($username);

        if ($usuario && password_verify($password, $usuario->passLogin)) {
            // Iniciar sesión
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Datos del Usuario
            $_SESSION['user_id'] = $usuario->idLogin;
            $_SESSION['user_name'] = $usuario->nombresLogin;
            $_SESSION['user_apellido_paterno'] = $usuario->apellidoPaternoLogin;
            $_SESSION['user_apellido_materno'] = $usuario->apellidoMaternoLogin;
            $_SESSION['user_acceso_login'] = $usuario->accesoLogin;

            // --- NUEVO: GUARDAR AÑO ACTIVO EN SESIÓN ---
            $anio = $this->maestrosDAO->obtenerAnioActivo();
            
            if ($anio) {
                $_SESSION['anio_id'] = $anio['idAnio'];
                $_SESSION['anio_nombre'] = $anio['nombreAnio'];
            } else {
                // Valores por defecto o manejo de error si no hay año activo
                $_SESSION['anio_id'] = null;
                $_SESSION['anio_nombre'] = "Sin periodo activo";
            }

            return true;
        }
        return false;
    }
}