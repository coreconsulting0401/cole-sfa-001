<?php
namespace App\Models;

class Grado {
    public function __construct(public ?int $idGrado = null, public ?string $nombreGrado = null) {}
}

class Nivel {
    public function __construct(public ?int $idNivel = null, public ?string $nombreNivel = null) {}
}

class Seccion {
    public function __construct(public ?int $idSeccion = null, public ?string $nombreSeccion = null) {}
}