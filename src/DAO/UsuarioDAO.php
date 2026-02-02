<?php
namespace App\DAO;

use App\Models\Usuario;
use PDO;

class UsuarioDAO {
    private $db;

    public function __construct($connection) {
        $this->db = $connection;
    }

    // Método para buscar un usuario por su username (para el Login)
    public function buscarPorUsername(string $username): ?Usuario {
        $sql = "SELECT * FROM login WHERE userLogin = :user LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user', $username);
        $stmt->execute();

        $row = $stmt->fetch();
        if ($row) {
            return new Usuario(
                $row['idLogin'],
                $row['userLogin'],
                $row['passLogin'],
                $row['nombresLogin'],
                $row['apellidoPaternoLogin'],
                $row['apellidoMaternoLogin'],
                $row['accesoLoginLogin'],
                $row['idPerfil']
            );
        }
        return null;
    }
}