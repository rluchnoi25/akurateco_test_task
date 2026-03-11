<?php

declare(strict_types=1);

namespace App\DTO;

class ProcessingResult
{
    public string $status;
    public string $message;
    public ?string $redirectUrl;

    public function __construct(
        string $status, 
        string $message, 
        ?string $redirectUrl = null
    ) {
        $this->status = $status;
        $this->message = $message;
        $this->redirectUrl = $redirectUrl;
    }
}
