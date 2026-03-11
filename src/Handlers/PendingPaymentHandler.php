<?php

declare(strict_types=1);

namespace App\Handlers;

use App\DTO\ProcessingResult;
use App\Entity\Payment;

class PendingPaymentHandler implements PaymentHandlerInterface
{
    public function supports(string $status): bool
    {
        return $status === 'PENDING';
    }

    public function handle(Payment $payment, array $response): ProcessingResult
    {
        $payment->setStatus('waiting');

        return new ProcessingResult(
            'waiting',
            'Waiting for customer action'
        );
    }
}
