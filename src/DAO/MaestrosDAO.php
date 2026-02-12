<?php
namespace App\DAO;
use PDO;

class MaestrosDAO {
    private $db;
    public function __construct($connection) { $this->db = $connection; }

    // --- MÉTODOS PARA LISTAR (READ) ---

    public function listarNiveles() {
        $stmt = $this->db->query("SELECT * FROM nivel ORDER BY idNivel DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarGrados() {
        $stmt = $this->db->query("SELECT * FROM grado ORDER BY idGrado DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarSecciones() {
        $stmt = $this->db->query("SELECT * FROM seccion ORDER BY idSeccion DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerAnioActivo() {
        // Intentamos con la tabla 'periodo' que aparece en tus archivos
        $stmt = $this->db->query("SELECT * FROM anio WHERE estadoAnio = '1' LIMIT 1");
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // --- MÉTODOS PARA REGISTRAR (CREAD) ---

    public function registrarGrado($nombre) {
        $stmt = $this->db->prepare("INSERT INTO grado (nombreGrado) VALUES (:nom)");
        return $stmt->execute([':nom' => $nombre]);
    }

    public function registrarNivel($nombre) {
        $stmt = $this->db->prepare("INSERT INTO nivel (nombreNivel) VALUES (:nom)");
        return $stmt->execute([':nom' => $nombre]);
    }

    public function registrarSeccion($nombre) {
        $stmt = $this->db->prepare("INSERT INTO seccion (nombreSeccion) VALUES (:nom)");
        return $stmt->execute([':nom' => $nombre]);
    }
}