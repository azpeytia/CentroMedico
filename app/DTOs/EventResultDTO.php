<?php

namespace App\DTOs;

class EventResultDTO
{
    public bool $result;
    public string $message;
    public array $values;
    public string $icon;

    /**
     * Create a new class instance.
     */
    public function __construct(bool $result = true , string $message = "Transacción exitosa", array $values = [], string $icon = "success")
    {
        $this->result = $result;
        $this->message = $message;
        $this->values = $values;
        $this->icon = $icon;
    }

    /**
     * Convert the DTO to an array.
     */
    public function toArray(): array
    {
        return [
            'result' => $this->result,
            'message' => $this->message,
            'values' => $this->values,
            'icon' => $this->icon,
        ];
    }
    
    /**
     * Create a DTO for a successful event.
     */
    public static function success(string $message = 'Transacción exitosa', array $values = [], string $icon = 'success'): self
    {
        return new self(true, $message, $values, $icon);
    }

    /**
     * Create a DTO for an error event.
     */
    public static function error(string $message = 'Ocurrió un error', array $values = [], string $icon = 'error'): self
    {
        return new self(false, $message, $values, $icon);
    }

    /* public function getResult(): bool
    {
        return $this->result;
    } */
}