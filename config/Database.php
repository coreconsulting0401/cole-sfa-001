<<?php
class Database {
    private $host = "localhost";
    private $db_name = "sistema_escolar";
    private $username = "root";
    private $password = ""; // Cambia esto si tienes contraseña en MySQL
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );
        } catch(PDOException $e) {
            error_log("Error de conexión: " . $e->getMessage());
        }
        return $this->conn;
    }
}