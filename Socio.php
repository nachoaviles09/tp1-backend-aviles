<?php
declare(strict_types=1);

require_once __DIR__ . '/Persona.php';

class Socio extends Persona
{
    private int $socio_id;
    private int $numeroSocio;
    private string $plan;

    public function __construct(
        int $socio_id,
        string $nombre,
        string $apellido,
        string $email,
        int $numeroSocio,
        string $plan
    ) {
        $this->setSocioId($socio_id);
        parent::__construct($nombre, $apellido, $email);
        $this->setNumeroSocio($numeroSocio);
        $this->setPlan($plan);
    }

    public function getSocioId(): int
    {
        return $this->socio_id;
    }

    public function setSocioId(int $socio_id): void
    {
        if ($socio_id <= 0) {
            throw new Exception("El ID del socio debe ser un entero positivo.");
        }
        $this->socio_id = $socio_id;
    }

    public function getNumeroSocio(): int
    {
        return $this->numeroSocio;
    }

    public function setNumeroSocio(int $numeroSocio): void
    {
        if ($numeroSocio <= 0) {
            throw new Exception("El número de socio debe ser un entero positivo.");
        }
        $this->numeroSocio = $numeroSocio;
    }

    public function getPlan(): string
    {
        return $this->plan;
    }

    public function setPlan(string $plan): void
    {
        $planNormalizado = strtolower(trim($plan));
        $planesValidos = ['mensual', 'trimestral', 'anual'];

        if (!in_array($planNormalizado, $planesValidos, true)) {
            throw new Exception("El plan debe ser: mensual, trimestral o anual.");
        }
        $this->plan = $planNormalizado;
    }

    public function describir(): string
    {
        return "Socio #{$this->socio_id} (N° {$this->numeroSocio}): {$this->nombre} {$this->apellido} - Plan: {$this->plan} | Contacto: {$this->email}";
    }
}