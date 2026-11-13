<?php
declare(strict_types=1);

class Persona
{
    protected string $nombre;
    protected string $apellido;
    protected string $email;

    public function __construct(string $nombre, string $apellido, string $email)
    {
        $this->setNombre($nombre);
        $this->setApellido($apellido);
        $this->setEmail($email);
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $nombre = trim($nombre);
        if ($nombre === '') {
            throw new Exception("El nombre no puede estar vacío.");
        }
        $this->nombre = $nombre;
    }

    public function getApellido(): string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): void
    {
        $apellido = trim($apellido);
        if ($apellido === '') {
            throw new Exception("El apellido no puede estar vacío.");
        }
        $this->apellido = $apellido;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $email = trim($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El formato del email no es válido.");
        }
        $this->email = $email;
    }

    public function describir(): string
    {
        return "{$this->nombre} {$this->apellido} ({$this->email})";
    }
}
