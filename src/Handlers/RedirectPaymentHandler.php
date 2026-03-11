<?php

declare(strict_types=1);

namespace App\Handlers;

use App\DTO\ProcessingResult;
use App\Entity\Payment;

class RedirectPaymentHandler implements PaymentHandlerInterface
{
    public function supports(string $status): bool
    {
        return $status === 'REDIRECT';
    }

    public function handle(Payment $payment, array $response): ProcessingResult
    {
        return new ProcessingResult(
            'redirect',
            'Customer redirect required',
            $response['redirect_url'] ?? null
        );
    }
}
