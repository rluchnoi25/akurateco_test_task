<?php

declare(strict_types=1);

namespace App\Handlers;

use App\DTO\ProcessingResult;
use App\Entity\Payment;

interface PaymentHandlerInterface
{
    public function supports(string $status): bool;

    public function handle(Payment $payment, array $response): ProcessingResult;
}
