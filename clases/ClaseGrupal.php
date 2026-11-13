<?php
declare(strict_types=1);

class ClaseGrupal
{
    private int $clase_grupal_id;
    private string $nombre;
    private string $dia;
    private int $cupoMaximo;
    private int $inscriptos = 0;
    private int $entrenador_id;

    public function __construct(
        int $clase_grupal_id,
        string $nombre,
        string $dia,
        int $cupoMaximo,
        int $inscriptos,
        int $entrenador_id
    ) {
        $this->setClaseGrupalId($clase_grupal_id);
        $this->setNombre($nombre);
        $this->setDia($dia);
        $this->setCupoMaximo($cupoMaximo);
        $this->setInscriptos($inscriptos);
        $this->setEntrenadorId($entrenador_id);
    }

    public function getClaseGrupalId(): int
    {
        return $this->clase_grupal_id;
    }

    public function setClaseGrupalId(int $clase_grupal_id): void
    {
        if ($clase_grupal_id <= 0) {
            throw new Exception("El ID de la clase grupal debe ser un entero positivo.");
        }
        $this->clase_grupal_id = $clase_grupal_id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $nombre = trim($nombre);
        if ($nombre === '') {
            throw new Exception("El nombre de la clase no puede estar vacío.");
        }
        $this->nombre = $nombre;
    }

    public function getDia(): string
    {
        return $this->dia;
    }

    public function setDia(string $dia): void
    {
        $diaNormalizado = strtolower(trim($dia));
        $diasValidos = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'];

        if (!in_array($diaNormalizado, $diasValidos, true)) {
            throw new Exception("El día debe ser de lunes a sabado (sin tilde).");
        }
        $this->dia = $diaNormalizado;
    }

    public function getCupoMaximo(): int
    {
        return $this->cupoMaximo;
    }

    public function setCupoMaximo(int $cupoMaximo): void
    {
        if ($cupoMaximo < 1 || $cupoMaximo > 50) {
            throw new Exception("El cupo máximo debe ser un entero entre 1 y 50.");
        }
        if ($this->inscriptos > $cupoMaximo) {
            throw new Exception("El cupo máximo no puede ser menor a la cantidad actual de inscriptos ({$this->inscriptos}).");
        }
        $this->cupoMaximo = $cupoMaximo;
    }

    public function getInscriptos(): int
    {
        return $this->inscriptos;
    }

    public function setInscriptos(int $inscriptos): void
    {
        if ($inscriptos < 0 || $inscriptos > $this->cupoMaximo) {
            throw new Exception("Los inscriptos deben ser un entero entre 0 y {$this->cupoMaximo}.");
        }
        $this->inscriptos = $inscriptos;
    }

    public function getEntrenadorId(): int
    {
        return $this->entrenador_id;
    }

    public function setEntrenadorId(int $entrenador_id): void
    {
        if ($entrenador_id <= 0) {
            throw new Exception("El ID del entrenador asociado debe ser un entero positivo.");
        }
        $this->entrenador_id = $entrenador_id;
    }

    public function hayCupo(): bool
    {
        return $this->inscriptos < $this->cupoMaximo;
    }

    public function cuposDisponibles(): int
    {
        return $this->cupoMaximo - $this->inscriptos;
    }

    public function inscribir(): void
    {
        if (!$this->hayCupo()) {
            throw new Exception("No hay cupo disponible");
        }
        $this->inscriptos++;
    }
}
