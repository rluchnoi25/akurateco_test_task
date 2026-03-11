<?php

declare(strict_types=1);

namespace App\Registry;

use App\Handlers\PaymentHandlerInterface;

class PaymentHandlerRegistry
{
    private array $handlers = [];

    public function registerHandler(PaymentHandlerInterface $handler): void
    {
        $this->handlers[] = $handler;
    }

    public function getHandler(string $status): ?PaymentHandlerInterface
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($status)) {
                return $handler;
            }
        }

        return null;
    }
}
