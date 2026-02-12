<?php
namespace App\DAO;

use PDO;

class MatriculaDAO {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function registrarMatriculaCompleta($datos) {
        try {
            $this->db->beginTransaction();

            // 1. Insertar Matrícula (Ajustado a tus columnas reales)
            $sqlMat = "INSERT INTO matricula (idEstudiante, idNivel, idGrado, idSeccion, idAnio, estadoMatricula) 
                    VALUES (:idEst, :idNiv, :idGra, :idSec, :idAnio, '1')";
            
            $stmtMat = $this->db->prepare($sqlMat);
            $stmtMat->execute([
                ':idEst'  => $datos['idEstudiante'],
                ':idNiv'  => $datos['idNivel'],
                ':idGra'  => $datos['idGrado'],
                ':idSec'  => $datos['idSeccion'],
                ':idAnio' => $datos['idAnio']
            ]);

            $idMatricula = $this->db->lastInsertId();

            // 2. Definir los 13 conceptos
            $conceptos = [
                'Matrícula', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 
                'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ];

            // 3. Insertar registros financieros con estado Pendiente
            $sqlFin = "INSERT INTO financiero (idMatricula, idAnio, conceptoFinanciero, montoFinanciero, estadoFinanciero) 
                    VALUES (:idMat, :idAnio, :concepto, :monto, 'Pendiente')";
            
            $stmtFin = $this->db->prepare($sqlFin);

            foreach ($conceptos as $concepto) {
                // Ejemplo de montos (puedes parametrizar esto después)
                $monto = ($concepto === 'Matrícula') ? 0.00 : 0.00;

                $stmtFin->execute([
                    ':idMat'     => $idMatricula,
                    ':idAnio'    => $datos['idAnio'],
                    ':concepto'  => $concepto,
                    ':monto'     => $monto
                ]);
            }

            $this->db->commit();
            return true;

        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Error en Matrícula/Financiero: " . $e->getMessage());
            return false;
        }
    }

    public function listarMatriculasPorAnio($idAnio) {
        $sql = "SELECT m.*, e.nombresEstudiante, e.apellidoPaternoEstudiante, e.apellidoMaternoEstudiante,
                    g.nombreGrado, s.nombreSeccion, n.nombreNivel
                FROM matricula m
                INNER JOIN estudiante e ON m.idEstudiante = e.idEstudiante
                INNER JOIN grado g ON m.idGrado = g.idGrado
                INNER JOIN seccion s ON m.idSeccion = s.idSeccion
                INNER JOIN nivel n ON m.idNivel = n.idNivel
                WHERE m.idAnio = :idAnio 
                ORDER BY e.apellidoPaternoEstudiante ASC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':idAnio' => $idAnio]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function obtenerTotalMatriculasPorAnio($idAnio) {
        // Contamos cuántos registros existen para el año académico actual
        $sql = "SELECT COUNT(*) FROM matricula WHERE idAnio = :idAnio";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':idAnio' => $idAnio]);
        
        // Retornamos el número total
        return $stmt->fetchColumn();
    }

    // Obtener total por nivel específico
    public function obtenerTotalPorNivel($idAnio, $idNivel) {
        $sql = "SELECT COUNT(*) FROM matricula WHERE idAnio = :idAnio AND idNivel = :idNivel";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':idAnio' => $idAnio, ':idNivel' => $idNivel]);
        return $stmt->fetchColumn();
    }
}