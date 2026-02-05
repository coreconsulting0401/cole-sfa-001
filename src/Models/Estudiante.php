<?php
namespace App\Models;

class Estudiante {
    public function __construct(
        public ?int $idEstudiante = null,
        public ?string $dniEstudiante = null,
        public ?string $nombresEstudiante = null,
        public ?string $apellidoPaternoEstudiante = null,
        public ?string $apellidoMaternoEstudiante = null,
        public ?string $emailEstudiante = null,
        public ?string $fechaNacimientoEstudiante = null,
        public ?string $fotoEstudiante = null,
        public ?string $dniPadreEstudiante = null,
        public ?string $nombresPadreEstudiante = null,
        public ?string $telefonoPadreEstudiante = null,
        public ?string $emailPadreEstudiante = null,
        public ?string $dniMadreEstudiante = null,
        public ?string $nombresMadreEstudiante = null,
        public ?string $telefonoMadreEstudiante = null,
        public ?string $emailMadreEstudiante = null,
        public ?string $dniTutorEstudiante = null,
        public ?string $nombresTutorEstudiante = null,
        public ?string $telefonoTutorEstudiante = null,
        public ?string $emailTutorEstudiante = null,
        public ?string $observacionEstudiante = null
    ) {}
}