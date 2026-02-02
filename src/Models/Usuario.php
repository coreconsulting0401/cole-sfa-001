<?php
namespace App\Models;

class Usuario {
    public ?int $idLogin;
    public ?string $userLogin;
    public ?string $passLogin;
    public ?string $nombresLogin;
    public ?string $apellidoPaternoLogin;
    public ?string $apellidoMaternoLogin;
    public ?string $accesoLogin;
    public ?int $idPerfil;

    public function __construct(
        ?int $idLogin = null, 
        ?string $userLogin = null, 
        ?string $passLogin = null,
        ?string $nombresLogin = null,
        ?string $apellidoPaternoLogin = null,
        ?string $apellidoMaternoLogin = null,
        ?string $accesoLogin = null,
        ?int $idPerfil = null
    ) {
        $this->idLogin = $idLogin;
        $this->userLogin = $userLogin;
        $this->passLogin = $passLogin;
        $this->nombresLogin = $nombresLogin;
        $this->apellidoPaternoLogin = $apellidoPaternoLogin;
        $this->apellidoMaternoLogin = $apellidoMaternoLogin;
        $this->accesoLogin = $accesoLogin;
        $this->idPerfil = $idPerfil;
    }
}