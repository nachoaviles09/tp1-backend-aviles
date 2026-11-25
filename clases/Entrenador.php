<?php
declare(strict_types=1);

require_once __DIR__ . '/Persona.php';

class Entrenador extends Persona
{
    private int $entrenador_id;
    private string $especialidad;
    private string $matricula;

    public function __construct(
        int $entrenador_id,
        string $nombre,
        string $apellido,
        string $email,
        string $especialidad,
        string $matricula
    ) {
        $this->setEntrenadorId($entrenador_id);
        parent::__construct($nombre, $apellido, $email);
        $this->setEspecialidad($especialidad);
        $this->setMatricula($matricula);
    }

    public function getEntrenadorId(): int
    {
        return $this->entrenador_id;
    }

    public function setEntrenadorId(int $entrenador_id): void
    {
        if ($entrenador_id <= 0) {
            throw new Exception("El ID del entrenador debe ser un entero positivo.");
        }
        $this->entrenador_id = $entrenador_id;
    }

    public function getEspecialidad(): string
    {
        return $this->especialidad;
    }

    public function setEspecialidad(string $especialidad): void
    {
        $especialidad = trim($especialidad);
        if ($especialidad === '') {
            throw new Exception("La especialidad no puede estar vacía.");
        }
        $this->especialidad = $especialidad;
    }

    public function getMatricula(): string
    {
        return $this->matricula;
    }

    public function setMatricula(string $matricula): void
    {
        $matricula = trim($matricula);
        if ($matricula === '') {
            throw new Exception("La matrícula no puede estar vacía.");
        }
        $this->matricula = $matricula;
    }

    public function describir(): string
    {
        return "Entrenador #{$this->entrenador_id}: {$this->nombre} {$this->apellido} - Especialidad: {$this->especialidad} (Matrícula: {$this->matricula}) | Contacto: {$this->email}";
    }
}