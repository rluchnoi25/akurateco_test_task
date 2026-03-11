<?php

declare(strict_types=1);

namespace App\Entity;

class Payment
{
    private int $id;
    private string $status;

    public function __construct(int $id, string $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
