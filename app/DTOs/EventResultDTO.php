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

    public function getResult(): bool
    {
        return $this->result;
    }
}