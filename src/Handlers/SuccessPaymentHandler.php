<?php

declare(strict_types=1);

namespace App\Handlers;

use App\DTO\ProcessingResult;
use App\Entity\Payment;

class SuccessPaymentHandler implements PaymentHandlerInterface
{
    public function supports(string $status): bool
    {
        return $status === 'SETTLED';
    }

    public function handle(Payment $payment, array $response): ProcessingResult
    {
        $payment->setStatus('paid');

        return new ProcessingResult(
            'success',
            'Payment completed successfully'
        );
    }
}
