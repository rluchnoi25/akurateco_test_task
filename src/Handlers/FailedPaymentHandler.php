<?php

declare(strict_types=1);

namespace App\Handlers;

use App\DTO\ProcessingResult;
use App\Entity\Payment;

class FailedPaymentHandler implements PaymentHandlerInterface
{
    public function supports(string $status): bool
    {
        return $status === 'DECLINED';
    }

    public function handle(Payment $payment, array $response): ProcessingResult
    {
        $payment->setStatus('failed');

        return new ProcessingResult(
            'declined',
            $response['message'] ?? 'Payment declined'
        );
    }
}
