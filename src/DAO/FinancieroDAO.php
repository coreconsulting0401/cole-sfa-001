<?php
namespace App\DAO;

use PDO;

class FinancieroDAO {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function listarPagosPorFiltro($idAnio, $idMatricula = null) {
        $sql = "SELECT f.*, e.nombresEstudiante, e.apellidoPaternoEstudiante, e.apellidoMaternoEstudiante 
                FROM financiero f
                INNER JOIN matricula m ON f.idMatricula = m.idMatricula
                INNER JOIN estudiante e ON m.idEstudiante = e.idEstudiante
                WHERE f.idAnio = :idAnio";

        if ($idMatricula) {
            $sql .= " AND f.idMatricula = :idMat";
        }

        $sql .= " ORDER BY e.apellidoPaternoEstudiante ASC, f.idFinanciero ASC";

        $stmt = $this->db->prepare($sql);
        $params = [':idAnio' => $idAnio];
        if ($idMatricula) { $params[':idMat'] = $idMatricula; }

        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarPago($idFinanciero, $monto) {
        $sql = "UPDATE financiero 
                SET estadoFinanciero = 'Pagado', 
                    montoFinanciero = :monto, 
                    fechaPago = NOW() 
                WHERE idFinanciero = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':monto' => $monto,
            ':id'    => $idFinanciero
        ]);
    }

    public function obtenerResumenAnual($idAnio) {
        $sql = "SELECT 
                    SUM(CASE WHEN estadoFinanciero = 'Pagado' THEN montoFinanciero ELSE 0 END) as recaudado,
                    SUM(CASE WHEN estadoFinanciero = 'Pendiente' THEN montoFinanciero ELSE 0 END) as pendiente,
                    COUNT(DISTINCT idMatricula) as totalAlumnos
                FROM financiero 
                WHERE idAnio = :idAnio";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':idAnio' => $idAnio]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerListaMorosos($idAnio) {
        $sql = "SELECT e.nombresEstudiante, e.apellidoPaternoEstudiante, f.conceptoFinanciero, f.montoFinanciero
                FROM financiero f
                INNER JOIN matricula m ON f.idMatricula = m.idMatricula
                INNER JOIN estudiante e ON m.idEstudiante = e.idEstudiante
                WHERE f.idAnio = :idAnio AND f.estadoFinanciero = 'Pendiente' AND f.montoFinanciero > 0
                ORDER BY e.apellidoPaternoEstudiante ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':idAnio' => $idAnio]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}