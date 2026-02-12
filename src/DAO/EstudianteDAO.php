<?php
namespace App\DAO;
use App\Models\Estudiante;
use PDO;

class EstudianteDAO {
    private $db;
    public function __construct($connection) { $this->db = $connection; }

   public function registrar(Estudiante $e) {
    $sql = "INSERT INTO estudiante (dniEstudiante, nombresEstudiante, apellidoPaternoEstudiante, apellidoMaternoEstudiante, emailEstudiante, fechaNacimientoEstudiante, fotoEstudiante, dniPadreEstudiante, nombresPadreEstudiante, telefonoPadreEstudiante, emailPadreEstudiante, dniMadreEstudiante, nombresMadreEstudiante, telefonoMadreEstudiante, emailMadreEstudiante, dniTutorEstudiante, nombresTutorEstudiante, telefonoTutorEstudiante, emailTutorEstudiante, observacionEstudiante) 
            VALUES (:dni, :nom, :apeP, :apeM, :em, :fNac, :foto, :dniP, :nomP, :telP, :emP, :dniMa, :nomMa, :telMa, :emMa, :dniT, :nomT, :telT, :emT, :obs)";
    
    $stmt = $this->db->prepare($sql);
    $exito = $stmt->execute([
        ':dni' => $e->dniEstudiante, ':nom' => $e->nombresEstudiante, ':apeP' => $e->apellidoPaternoEstudiante,
        ':apeM' => $e->apellidoMaternoEstudiante, ':em' => $e->emailEstudiante, ':fNac' => $e->fechaNacimientoEstudiante,
        ':foto' => $e->fotoEstudiante, ':dniP' => $e->dniPadreEstudiante, ':nomP' => $e->nombresPadreEstudiante,
        ':telP' => $e->telefonoPadreEstudiante, ':emP' => $e->emailPadreEstudiante, ':dniMa' => $e->dniMadreEstudiante,
        ':nomMa' => $e->nombresMadreEstudiante, ':telMa' => $e->telefonoMadreEstudiante, ':emMa' => $e->emailMadreEstudiante,
        ':dniT' => $e->dniTutorEstudiante, ':nomT' => $e->nombresTutorEstudiante, ':telT' => $e->telefonoTutorEstudiante,
        ':emT' => $e->emailTutorEstudiante, ':obs' => $e->observacionEstudiante
    ]);

    // SI EL INSERT FUE EXITOSO, DEVOLVEMOS EL ID, SI NO, FALSE
    return $exito ? $this->db->lastInsertId() : false;
}

    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM estudiante WHERE idEstudiante = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar(Estudiante $estudiante) {
        $sql = "UPDATE estudiante SET 
                    dniEstudiante = :dni, nombresEstudiante = :nom, 
                    apellidoPaternoEstudiante = :apeP, apellidoMaternoEstudiante = :apeM, 
                    emailEstudiante = :email, fechaNacimientoEstudiante = :fNac,
                    dniPadreEstudiante = :dniP, nombresPadreEstudiante = :nomP,
                    telefonoPadreEstudiante = :telP, emailPadreEstudiante = :mailP,
                    dniMadreEstudiante = :dniM, nombresMadreEstudiante = :nomM,
                    telefonoMadreEstudiante = :telM, emailMadreEstudiante = :mailM,
                    dniTutorEstudiante = :dniT, nombresTutorEstudiante = :nomT,
                    telefonoTutorEstudiante = :telT, emailTutorEstudiante = :mailT,
                    observacionEstudiante = :obs
                WHERE idEstudiante = :id";

        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':dni'   => $estudiante->dniEstudiante,
            ':nom'   => $estudiante->nombresEstudiante,
            ':apeP'  => $estudiante->apellidoPaternoEstudiante,
            ':apeM'  => $estudiante->apellidoMaternoEstudiante,
            ':email' => $estudiante->emailEstudiante,
            ':fNac'  => $estudiante->fechaNacimientoEstudiante,
            ':dniP'  => $estudiante->dniPadreEstudiante,
            ':nomP'  => $estudiante->nombresPadreEstudiante,
            ':telP'  => $estudiante->telefonoPadreEstudiante,
            ':mailP' => $estudiante->emailPadreEstudiante,
            ':dniM'  => $estudiante->dniMadreEstudiante,
            ':nomM'  => $estudiante->nombresMadreEstudiante,
            ':telM'  => $estudiante->telefonoMadreEstudiante,
            ':mailM' => $estudiante->emailMadreEstudiante,
            ':dniT'  => $estudiante->dniTutorEstudiante,
            ':nomT'  => $estudiante->nombresTutorEstudiante,
            ':telT'  => $estudiante->telefonoTutorEstudiante,
            ':mailT' => $estudiante->emailTutorEstudiante,
            ':obs'   => $estudiante->observacionEstudiante,
            ':id'    => $estudiante->idEstudiante // Este es vital para el WHERE
        ]);
    }

    public function contarTotalEstudiantes($busqueda = '') {
        $sql = "SELECT COUNT(*) FROM estudiante WHERE nombresEstudiante LIKE :busq OR dniEstudiante LIKE :busq";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':busq' => "%$busqueda%"]);
        return $stmt->fetchColumn();
    }

    public function listarPaginado($inicio, $cantidad, $busqueda = '') {
        $sql = "SELECT * FROM estudiante 
                WHERE nombresEstudiante LIKE :busq OR dniEstudiante LIKE :busq 
                ORDER BY idEstudiante DESC LIMIT :inicio, :cantidad";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':busq', "%$busqueda%", \PDO::PARAM_STR);
        $stmt->bindValue(':inicio', (int)$inicio, \PDO::PARAM_INT);
        $stmt->bindValue(':cantidad', (int)$cantidad, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function verificarMatriculaActiva($idEstudiante, $idAnio) {
        $sql = "SELECT COUNT(*) FROM matricula 
                WHERE idEstudiante = :idEst 
                AND idAnio = :idAnio 
                AND estadoMatricula = '1'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':idEst' => $idEstudiante,
            ':idAnio' => $idAnio
        ]);
        
        return $stmt->fetchColumn() > 0; // Retorna true si ya existe
    }

    public function listarEstudiantes() {
    $sql = "SELECT idEstudiante, nombresEstudiante, apellidoPaternoEstudiante, 
                   apellidoMaternoEstudiante, dniEstudiante, estadoEstudiante 
            FROM estudiante ORDER BY idEstudiante DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}